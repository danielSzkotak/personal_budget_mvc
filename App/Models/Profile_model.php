<?php

namespace App\Models;

use App\Auth;
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

    public function updateExpenseCategoryName(){

  
        $sql = 'UPDATE expenses_category_assigned_to_users SET name = :name WHERE expenses_category_assigned_to_users.id = :categoryID';  

       $db = static::getDB();
       $stmt = $db->prepare($sql);

       $stmt->bindValue(':name', $this->categoryName, PDO::PARAM_STR);
       $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);

       $stmt->execute();
   }

    public function deleteIncomeCategory(){

        $sql = 'DELETE FROM incomes_category_assigned_to_users WHERE incomes_category_assigned_to_users.id = :categoryID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteExpenseCategory(){
        
        $sql = 'DELETE FROM expenses_category_assigned_to_users WHERE expenses_category_assigned_to_users.id = :categoryID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addIncomeCategory(){

       $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) VALUES (:userID, :categoryName)';

       $db = static::getDB();
       $stmt = $db->prepare($sql);

       $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
       $stmt->bindValue(':categoryName', $this->newCategoryName, PDO::PARAM_STR);

       $stmt->execute();
   }

   public function addExpenseCategory(){

    $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) VALUES (:userID, :categoryName)';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
    $stmt->bindValue(':categoryName', $this->newCategoryName, PDO::PARAM_STR);

    $stmt->execute();
}


   
}

  


