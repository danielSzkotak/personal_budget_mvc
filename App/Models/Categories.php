<?php

namespace App\Models;

use PDO;
use App\Auth;
use App\Config;

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


 }