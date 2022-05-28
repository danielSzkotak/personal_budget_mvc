<?php

namespace App\Models;

use App\Mail;
use App\Token;
use Core\View;
use PDO;

/**
 * User model
 */
class User extends \Core\Model
{

    /**
     * Errors messeges from validation
     */
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return void
     */
    public function save()
    {
            $this->validate();

            if(empty($this->errors)){

                $password = password_hash($this->password, PASSWORD_DEFAULT);

                $token = new Token();
                $hashed_token = $token->getHash();
                $this->activation_token = $token->getValue();

                $sql = "INSERT INTO users (username, password, email, activation_hash) VALUES (:username, :password, :email, :activation_hash)";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_STR);
                $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

                return $stmt->execute();
            }

            return false;
    }

    public function copyCategories($id)
    {         
                $sql = "
                
                INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.id, expenses_category_default.name FROM users, expenses_category_default WHERE users.id = :id;

                INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.id, incomes_category_default.name FROM users, incomes_category_default WHERE users.id = :id;

                INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT users.id, payment_methods_default.name FROM users, payment_methods_default WHERE users.id = :id;"
                
                ;

                $db = static::getDB();

                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);

                $stmt->execute();                        
    }

    public function validate(){
        // Name
        if ($this->username == '') {
            $this->errors[] = 'Nazwa użytwkonika jest wymagana';
        }

        if (strlen($this->username) < 4) {
            $this->errors[] = 'Nazwa użytkownika powinna mieć min. 4 znaki';
        }
 
        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Nieprawidłowy adres Email';
        }

        if (static::emailExists($this->email, $this->id ?? null)){
            $this->errors[] = "Taki adres Email jest już zajęty";
        }
 
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Hasło powinno mięć min. 6 znaków';
        }
 
        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło wymaga conajmniej jednej litery';
        }
 
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło wymaga conajmniej jednej cyfry';
        }
     }

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if($user){

            if($user->id != $ignore_id){
                return true;
            }
        }

        return false;
    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        //
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getIdByEmail($email)
    {
        $sql = 'SELECT id FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        $fetched_id = $stmt->fetch();

        return reset($fetched_id); //get the first element of array (id)
        
    }


    /**
     * Authenticate a user by email and password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user && $user->is_active) {
            if (password_verify($password, $user->password)) {
                return $user;
            }      
        }

        return false;
    }

    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public function rememberLogin(){

        $token = new Token();
        $hashed_token = $token->getHash();

        //Making properties
        $this->remember_token = $token->getValue();

        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30; //30 days from now

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at) VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function sendPasswordReset($email){

        $user = static::findByEmail($email);

        if($user){

           if($user->startPasswordReset()){

              $user->sendPasswordResetEmail();
           }

        }
    }

    protected function startPasswordReset(){

        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2; //2 hours from now

        $sql = 'UPDATE users SET password_reset_hash = :token_hash,
                password_reset_exp = :expires_at WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    protected function sendPasswordResetEmail(){

        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
        $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);

        Mail::send($this->email, 'Resetowanie hasła', $text, $html);
    }

    public static function findByPasswordReset($token){

        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if($user) {
            
            //Check password reset token hasn't expired
            if(strtotime($user->password_reset_exp) > time()){

                return $user;
            }
        }
    }

    /**
     * Reset the password server side
     */

    public function resetPassword($password){

        $this->password = $password;

        $this->validate();
        
        if (empty($this->errors)){

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users SET password = :password_hash,
            password_reset_hash = NULL,
            password_reset_exp = NULL
            WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    public function sendActivationEmail(){

        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;

        $text = View::getTemplate('Signup/activation_email.txt', ['url' => $url]);
        $html = View::getTemplate('Signup/activation_email.html', ['url' => $url]);

        Mail::send($this->email, 'Aktywacja konta', $text, $html);
    }

    public static function activate($value){

        $token = new Token($value);
        $hashed_token = $token->getHash();

        $sql = 'UPDATE users SET is_active = 1,
            activation_hash = NULL
            WHERE activation_hash = :hashed_token';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

            $stmt->execute();
    }

    
}

