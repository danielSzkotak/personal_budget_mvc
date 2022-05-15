<?php

namespace App\Models;

use PDO;


 class Profile_model extends \Core\Model{

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        };
    }

    public function updateIncomeCategoryName(){

  
         $sql = 'UPDATE incomes_category_assigned_to_users SET name = :name WHERE incomes_category_assigned_to_users.id = :categoryID';  

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $this->categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);

        $stmt->execute();
    }

   
}

  


