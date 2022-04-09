<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Models\Expense_model;
use App\Serviceable;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Expense extends Authenticated {

    /**
     * Show the addExpense page
     *
     * @return void
     */
    public function addExpenseAction()
    {
        
        $expenseCat = Categories::getExpenseCategories($_SESSION['user_id']);
        $expensePayment = Categories::getExpensePayment($_SESSION['user_id']);
        $_SESSION['expense_cat'] = $expenseCat;
        $_SESSION['expense_payment'] = $expensePayment;

        View::renderTemplate('Expense/addExpense.html');
    }

    /**
     * Add expense
     *
     * @return void
     */
    public function addAction()
    {
   
        if(isset($_POST["submitExpense"])){

            $_SESSION['expense_submitted'] = true;
          
            $amount = Serviceable::formatAmountToModal($_POST["expenseAmount"]);
            $date = Serviceable::formatDateToModal($_POST["expenseDate"]);
            $categoryID = Serviceable::fetchIDFromOptionValue($_POST["expenseCategory"]);
            $categoryName = Serviceable::fetchNameFromOptionValue($_POST["expenseCategory"]);

            $paymentID = Serviceable::fetchIDFromOptionValue($_POST["expensePayment"]);
            $paymentName = Serviceable::fetchNameFromOptionValue($_POST["expensePayment"]);

            $expense = new Expense_model($_SESSION['user_id'], $categoryID, $paymentID, $amount, $_POST["expenseDate"]);
            $expense->addExpense();
            
            View::renderTemplate('Expense/addExpense.html', [
                'expense_amount' => $amount.' zł',
                'expense_date' => $date,
                'expense_cat' => $categoryName,
                'expense_payment' => $paymentName
            ]);

            unset( $_SESSION['expense_submitted']);
        }
    }

}
