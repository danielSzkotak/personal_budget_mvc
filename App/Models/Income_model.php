<?php

namespace App\Models;

use PDO;



 class Income_model extends \Core\Model{

    private $uID;
    private $amount;
    private $date;
    private $category;

    public function __construct($amount, $date, $category, $uID)
    {
        $this->uID = $uID;
        $this->amount = $amount;
        $this->date = $date;
        $this->category = $category;
    }

    public function addIncome(){
  
        $sql = "INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income) VALUES (:uID, :categoryID, :amount, :date)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':uID', $this->uID, PDO::PARAM_INT);
        $stmt->bindValue(':categoryID', $this->category, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);

        $stmt->execute();
    }

   
}

  


