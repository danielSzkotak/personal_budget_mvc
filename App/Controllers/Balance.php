<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Balance_model;
use \Core\View;



/**
 * Login controller
 *
 * PHP version 7.0
 */
class Balance extends Authenticated {

    /**
     * Show the addIncome page
     *
     * @return void
     */
    public function periodAction()
    {

        View::renderTemplate('Balance/period.html');
    }

    public function balanceAction()
    {

        $balance = new Balance_model($_POST);
        $incomes = $balance->getCurrentMonthIncomesBalance($_SESSION['user_id']);
        $incomesSum = $balance->getCurrentMonthIncomesSum($_SESSION['user_id']);
        $expenses = $balance->getCurrentMonthExpensesBalance($_SESSION['user_id']);
        $expensesSum = $balance->getCurrentMonthExpensesSum($_SESSION['user_id']);

        View::renderTemplate('Balance/period.html',[
            'incomes' => $incomes,
            'incomesSum' => $incomesSum,
            'expenses' => $expenses,
            'expensesSum' => $expensesSum
        ]);
      
            // $this->redirect('/balance/period',[
            //     'incomes' => $incomes
            // ]);
        
    }

    

}
