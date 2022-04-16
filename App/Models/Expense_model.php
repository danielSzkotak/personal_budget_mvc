<?php

namespace App\Models;

use PDO;


 class Expense_model extends \Core\Model{

    private $uID;
    private $amount;
    private $date;
    private $expenseCategoryID;
    private $expensePaymentID;

    public function __construct($uID, $expenseCategoryID, $expensePaymentID, $amount, $date)
    {
        $this->uID = $uID;
        $this->amount = $amount;
        $this->date = $date;
        $this->expenseCategoryID = $expenseCategoryID;
        $this->expensePaymentID = $expensePaymentID;
    }

    public function addExpense(){
  
        $sql = "INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) VALUES (:uID, :expense_categoryID, :payment_methodID, :amount, :date, '')";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':uID', $this->uID, PDO::PARAM_INT);
        $stmt->bindValue(':expense_categoryID', $this->expenseCategoryID, PDO::PARAM_INT);
        $stmt->bindValue(':payment_methodID', $this->expensePaymentID, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);

        $stmt->execute();
    }

   
}

  


