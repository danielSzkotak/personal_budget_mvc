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

    public function validate(){
        // Name
        if ($this->username == '') {
            $this->errors[] = 'Name is required';
        }
 
        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        if (static::emailExists($this->email)){
            $this->errors[] = "email already taken";
        }
 
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }
 
        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }
 
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }
     }

     public static function emailExists($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch() ? true : false; 
    }
  
}
