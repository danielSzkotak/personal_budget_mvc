<?php

namespace App\Models;

use PDO;


 class Balance_model extends \Core\Model{
  

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        };
    }
    
    
    public function getCurrentMonthIncomesBalance($userID){

        $firstDayOfTheMonth = date('Y-m-01');
        $lastDayOfTheMonth = date('Y-m-t');

        $sql = "SELECT incomes_category_assigned_to_users.name, ROUND(SUM(incomes.amount),2) AS category_sum FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) GROUP BY incomes_category_assigned_to_users.name ORDER BY category_sum DESC;";
  
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();

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

     public function getCurrentMonthIncomesSum($userID){

        $firstDayOfTheMonth = date('Y-m-01');
        $lastDayOfTheMonth = date('Y-m-t');

        $sql = "SELECT ROUND(SUM(incomes.amount),2) AS total FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id);";
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
        
     }

     public function getCurrentMonthExpensesBalance($userID){

        $firstDayOfTheMonth = date('Y-m-01');
        $lastDayOfTheMonth = date('Y-m-t');

        $sql = "SELECT expenses_category_assigned_to_users.name, ROUND(SUM(expenses.amount),2) AS category_sum FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) GROUP BY expenses_category_assigned_to_users.name ORDER BY category_sum DESC;";
  
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();

     }

     public function getCurrentMonthExpensesSum($userID){

        $firstDayOfTheMonth = date('Y-m-01');
        $lastDayOfTheMonth = date('Y-m-t');

        $sql = "SELECT ROUND(SUM(expenses.amount),2) AS total FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id);";
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
        
     }

     public function getPreviousMonthIncomesBalance($userID){

        $firstDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $lastDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

        $sql = "SELECT incomes_category_assigned_to_users.name, ROUND(SUM(incomes.amount),2) AS category_sum FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) GROUP BY incomes_category_assigned_to_users.name ORDER BY category_sum DESC;";
  
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();

     }

     public function getPreviousMonthIncomesSum($userID){

        $firstDayOfTheMonth = date("Y-m-01", mktime(0, 0, 0, date("m")-1, 1));
        $lastDayOfTheMonth = date("Y-m-t", mktime(0, 0, 0, date("m"), 0));

        $sql = "SELECT ROUND(SUM(incomes.amount),2) AS total FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id);";
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
        
     }

     public function getPreviousMonthExpensesBalance($userID){

        $firstDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $lastDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

        $sql = "SELECT expenses_category_assigned_to_users.name, ROUND(SUM(expenses.amount),2) AS category_sum FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) GROUP BY expenses_category_assigned_to_users.name ORDER BY category_sum DESC;";
  
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();

     }

     public function getPreviousMonthExpensesSum($userID){

        $firstDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $lastDayOfTheMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

        $sql = "SELECT ROUND(SUM(expenses.amount),2) AS total FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheMonth' AND '$lastDayOfTheMonth') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id);";
  
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchAll();
        
     }

     public function getCurrentYearIncomesBalance($userID){

      $firstDayOfTheYear = date("Y-01-01");
      $lastDayOfTheYear = date('Y') . '-12-31';

      $sql = "SELECT incomes_category_assigned_to_users.name, ROUND(SUM(incomes.amount),2) AS category_sum FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheYear' AND '$lastDayOfTheYear') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) GROUP BY incomes_category_assigned_to_users.name ORDER BY category_sum DESC;";


      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

   public function getCurrentYearIncomesSum($userID){

      $firstDayOfTheYear = date("Y-01-01");
      $lastDayOfTheYear = date('Y') . '-12-31';

      $sql = "SELECT ROUND(SUM(incomes.amount),2) AS total FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$firstDayOfTheYear' AND '$lastDayOfTheYear') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id);";

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();
      
   }

   
   public function getCurrentYearExpensesBalance($userID){

      $firstDayOfTheYear = date("Y-01-01");
      $lastDayOfTheYear = date('Y') . '-12-31';

      $sql = "SELECT expenses_category_assigned_to_users.name, ROUND(SUM(expenses.amount),2) AS category_sum FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheYear' AND '$lastDayOfTheYear') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) GROUP BY expenses_category_assigned_to_users.name ORDER BY category_sum DESC;";


      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }
     

   public function getCurrentYearExpensesSum($userID){

      $firstDayOfTheYear = date("Y-01-01");
      $lastDayOfTheYear = date('Y') . '-12-31';

      $sql = "SELECT ROUND(SUM(expenses.amount),2) AS total FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$firstDayOfTheYear' AND '$lastDayOfTheYear') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id);";

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();
      
   }

   public function getCustomDatesIncomesBalance($userID, $startDate, $endDate){


      $sql = "SELECT incomes_category_assigned_to_users.name, ROUND(SUM(incomes.amount),2) AS category_sum FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$startDate' AND '$endDate') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id) GROUP BY incomes_category_assigned_to_users.name ORDER BY category_sum DESC;";


      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

   public function getCustomDatesExpensesBalance($userID, $startDate, $endDate){


      $sql = "SELECT expenses_category_assigned_to_users.name, ROUND(SUM(expenses.amount),2) AS category_sum FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$startDate' AND '$endDate') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id) GROUP BY expenses_category_assigned_to_users.name ORDER BY category_sum DESC;";


      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

   public function getCustomDatesIncomesSum($userID, $startDate, $endDate){


      $sql = "SELECT ROUND(SUM(incomes.amount),2) AS total FROM incomes_category_assigned_to_users, incomes WHERE (incomes.date_of_income BETWEEN '$startDate' AND '$endDate') AND (incomes_category_assigned_to_users.user_id=:userID) AND (incomes_category_assigned_to_users.user_id = incomes.user_id) AND (incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id);";


      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

   public function getCustomDatesExpensesSum($userID, $startDate, $endDate){


      $sql = "SELECT ROUND(SUM(expenses.amount),2) AS total FROM expenses_category_assigned_to_users, expenses WHERE (expenses.date_of_expense BETWEEN '$startDate' AND '$endDate') AND (expenses_category_assigned_to_users.user_id=:userID) AND (expenses_category_assigned_to_users.user_id = expenses.user_id) AND (expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id);";

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
  
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();

      return $stmt->fetchAll();

   }

     public function getBalancePeriod(){

        return $this->balancePeriod;
    }
   
}

  


