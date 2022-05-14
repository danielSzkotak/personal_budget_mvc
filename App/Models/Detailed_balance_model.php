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

   public function getCurrentMonthDetailedExpenses($userID){

    $firstDayOfTheMonth = date('Y-m-01');
    $lastDayOfTheMonth = date('Y-m-t');

    $sql = "SELECT expenses.id, expenses_category_assigned_to_users.name, expenses.amount, expenses.date_of_expense FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) ORDER BY expenses.amount DESC;";


    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();

 }

 public function deleteExpense($expenseID){

    $sql = "DELETE FROM expenses WHERE expenses.id=:expenseID";

    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':expenseID', $expenseID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();

 } 

 public function getPreviousMonthDetailedIncomes($userID){

    $firstDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
    $lastDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

    $sql = "SELECT incomes.id, incomes_category_assigned_to_users.name, incomes.amount, incomes.date_of_income FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) ORDER BY incomes.amount DESC;";


    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();

 }

 public function getPreviousMonthDetailedExpenses($userID){

    $firstDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
    $lastDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

    $sql = "SELECT expenses.id, expenses_category_assigned_to_users.name, expenses.amount, expenses.date_of_expense FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) ORDER BY expenses.amount DESC;";


    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->execute();

    return $stmt->fetchAll();

 }
}

  


