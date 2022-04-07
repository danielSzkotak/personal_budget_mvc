<?php

namespace App\Models;

use PDO;

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


 }