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

   public function updatePaymentCategoryName(){

    $sql = 'UPDATE payment_methods_assigned_to_users SET name = :name WHERE payment_methods_assigned_to_users.id = :categoryID';  

   $db = static::getDB();
   $stmt = $db->prepare($sql);

   $stmt->bindValue(':name', $this->categoryName, PDO::PARAM_STR);
   $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);

   $stmt->execute();
}

   public function isIncomeCategoryEmpty(){

    $sql = 'SELECT * FROM incomes WHERE incomes.income_category_assigned_to_user_id = :categoryID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
    $stmt->execute();
    
    if (empty($stmt->fetchAll())){
        return true;
    } else {
        return false;
    }
}

public function isExpenseCategoryEmpty(){

    $sql = 'SELECT * FROM expenses WHERE expenses.expense_category_assigned_to_user_id = :categoryID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
    $stmt->execute();
    
    if (empty($stmt->fetchAll())){
        return true;
    } else {
        return false;
    }
}

public function isPaymentCategoryEmpty(){

    $sql = 'SELECT * FROM expenses WHERE expenses.payment_method_assigned_to_user_id = :categoryID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
    $stmt->execute();
    
    if (empty($stmt->fetchAll())){
        return true;
    } else {
        return false;
    }
}

    public function deleteEmptyIncomeCategory(){

        $sql = 'DELETE FROM incomes_category_assigned_to_users WHERE incomes_category_assigned_to_users.id = :categoryID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteEmptyExpenseCategory(){
        
        $sql = 'DELETE FROM expenses_category_assigned_to_users WHERE expenses_category_assigned_to_users.id = :categoryID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':categoryID', $this->categoryID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteEmptyPaymentCategory(){
        
        $sql = 'DELETE FROM payment_methods_assigned_to_users WHERE payment_methods_assigned_to_users.id = :categoryID';

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
       $stmt->bindValue(':categoryName', $this->categoryToAddName, PDO::PARAM_STR);

       $stmt->execute();
   }

    public function addExpenseCategory()
    {

        $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) VALUES (:userID, :categoryName)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryName', $this->categoryToAddName, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function addPaymentCategory()
    {

        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) VALUES (:userID, :categoryName)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryName', $this->categoryToAddName, PDO::PARAM_STR);

        $stmt->execute();
    }

    

    public function transportIncomesFromDeletedCategory()
    {

        $sql = 'UPDATE incomes SET income_category_assigned_to_user_id = :inneID WHERE income_category_assigned_to_user_id = :categoryToDeleteID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':inneID', Categories::getIncomeIndelibleCategoryID(), PDO::PARAM_INT);
        $stmt->bindValue(':categoryToDeleteID', $this->categoryID, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function transportExpensesFromDeletedCategory()
    {

        $sql = 'UPDATE expenses SET expense_category_assigned_to_user_id = :inneID WHERE expense_category_assigned_to_user_id = :categoryToDeleteID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':inneID', Categories::getExpenseIndelibleCategoryID(), PDO::PARAM_INT);
        $stmt->bindValue(':categoryToDeleteID', $this->categoryID, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function transportPaymentFromDeletedCategory()
    {

        $sql = 'UPDATE expenses SET payment_method_assigned_to_user_id = :inneID WHERE payment_method_assigned_to_user_id = :categoryToDeleteID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':inneID', Categories::getPaymentIndelibleCategoryID(), PDO::PARAM_INT);
        $stmt->bindValue(':categoryToDeleteID', $this->categoryID, PDO::PARAM_STR);

        $stmt->execute();
    }


   
}

  


