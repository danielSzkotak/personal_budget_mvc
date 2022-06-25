<?php

namespace App\Models;

use PDO;
use App\Auth;
use App\Config;
use App\Serviceable;

/**
 * Remembered Logib model
 */

 class Categories extends \Core\Model{

   public static function getIncomeCategories($userID){

        $sql = 'SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id = :userID';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
   }

   public static function getExpenseCategories($userID){

    $sql = 'SELECT id, name FROM expenses_category_assigned_to_users WHERE user_id = :userID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();
   }

   public static function getExpensePayment($userID){

    $sql = 'SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id = :userID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();
   }

   public function getUser(){

      return User::findByID($this->user_id);
   }

   public static function getIncomeIndelibleCategoryID(){

    $sql = 'SELECT id FROM incomes_category_assigned_to_users WHERE name = :inne AND user_id = :userID';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':inne', Config::INDELIBLE_CATEGORY, PDO::PARAM_STR);
    $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetchColumn();
}

public static function getExpenseIndelibleCategoryID(){

   $sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE name = :inne AND user_id = :userID';

   $db = static::getDB();
   $stmt = $db->prepare($sql);

   $stmt->bindValue(':inne', Config::INDELIBLE_CATEGORY, PDO::PARAM_STR);
   $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

   $stmt->execute();

   return $stmt->fetchColumn();
}

public static function getPaymentIndelibleCategoryID(){

   $sql = 'SELECT id FROM payment_methods_assigned_to_users WHERE name = :inne AND user_id = :userID';

   $db = static::getDB();
   $stmt = $db->prepare($sql);

   $stmt->bindValue(':inne', Config::INDELIBLE_CATEGORY, PDO::PARAM_STR);
   $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

   $stmt->execute();

   return $stmt->fetchColumn();
}

    public static function incomeCategoryExists($newCategory)
    {
        $category = static::findByIncomeCategoryName($newCategory);

        if ($category) {

            return true;
        }

        return false;
    }

    public static function expenseCategoryExists($newCategory)
    {
        $category = static::findByExpenseCategoryName($newCategory);

        if ($category) {

            return true;
        }

        return false;
    }

    public static function paymentCategoryExists($newCategory)
    {
        $category = static::findByPaymentCategoryName($newCategory);

        if ($category) {

            return true;
        }

        return false;
    }

    public static function findByIncomeCategoryName($incomeCategoryName)
    {
        $sql = "SELECT * FROM incomes_category_assigned_to_users WHERE name = :name AND user_id = :userID";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $incomeCategoryName, PDO::PARAM_STR);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function findByExpenseCategoryName($expenseCategoryName)
    {
        $sql = "SELECT * FROM expenses_category_assigned_to_users WHERE name = :name AND user_id = :userID";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $expenseCategoryName, PDO::PARAM_STR);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function findByPaymentCategoryName($paymentCategoryName)
    {
        $sql = "SELECT * FROM payment_methods_assigned_to_users WHERE name = :name AND user_id = :userID";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $paymentCategoryName, PDO::PARAM_STR);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    //-----------------------------API------------------------------------------

    public static function isSetLimit($categoryID){

        $sql = 'SELECT is_limit FROM expenses_category_assigned_to_users WHERE user_id = :userID AND id = :ID';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
        $stmt->bindValue(':ID', $categoryID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        $stmt->execute();
    
        return $stmt->fetch();
    }

    public static function getCategoryLimit($categoryID){

        $sql = 'SELECT control_limit FROM expenses_category_assigned_to_users WHERE user_id = :userID AND id = :ID';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
        $stmt->bindValue(':ID', $categoryID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        $stmt->execute();
    
        return $stmt->fetchAll();
    }

       public static function getCategorySumFromSelectedMonth($categoryID, $date){

        $firstDayOfTheMonth = date('Y-m-01', strtotime($date));
        $lastDayOfTheMonth = date('Y-m-t', strtotime($date));
        
        $sql = "SELECT ROUND(SUM(expenses.amount),2) AS category_sum FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) AND expenses.expense_category_assigned_to_user_id=:categoryID";
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', Auth::getUser()->id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
        
     }


 }