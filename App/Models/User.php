<?php

namespace App\Models;

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

    public function __construct($data)
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

                $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_STR);

                return $stmt->execute();
            }

            return false;
    }

    public function copyCategories()
    {         
                $sql = "
                
                INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.id, expenses_category_default.name FROM expenses_category_default, users WHERE users.username=:username;

                INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.id, incomes_category_default.name FROM incomes_category_default, users WHERE users.username=:username;

                INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT users.id, payment_methods_default.name FROM payment_methods_default, users WHERE users.username=:username;
                
                ";

                $db = static::getDB();

                $stmt = $db->prepare($sql);
                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
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

        if (static::emailExists($this->email)){
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

     public static function emailExists($email)
    {
        $sql = 'SELECT email FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch() ? true : false; 
    }
  
}
