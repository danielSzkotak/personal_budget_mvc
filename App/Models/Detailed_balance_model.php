<?php

namespace App\Models;

use PDO;


 class Detailed_balance_model extends \Core\Model{
  

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        };
    }
    
    
    public function getCurrentMonthDetailedIncomes($userID){

        $firstDayOfTheMonth = date('Y-m-01');
        $lastDayOfTheMonth = date('Y-m-t');

        $sql = "SELECT incomes.id, incomes_category_assigned_to_users.name, incomes.amount, incomes.date_of_income FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) ORDER BY incomes.amount DESC;";
  
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();

     }

     public function deleteIncome($incomeID){

      $sql = "DELETE FROM incomes WHERE incomes.id=:incomeID";

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':incomeID', $incomeID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

     
}

  


