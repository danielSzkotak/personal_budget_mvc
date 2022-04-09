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

        if(isset($_POST['submitBalance'])){

        $balance = new Balance_model($_POST);
        $balancePeriod = $balance->getBalancePeriod();

        switch ($balancePeriod) {
            case "currentMonth":

                $incomes = $balance->getCurrentMonthIncomesBalance($_SESSION['user_id']);
                $incomesSum = $balance->getCurrentMonthIncomesSum($_SESSION['user_id']);
                $expenses = $balance->getCurrentMonthExpensesBalance($_SESSION['user_id']);
                $expensesSum = $balance->getCurrentMonthExpensesSum($_SESSION['user_id']);
              
              break;
            case "previousMonth":

                $incomes = $balance->getPreviousMonthIncomesBalance($_SESSION['user_id']);
                $incomesSum = $balance->getPreviousMonthIncomesSum($_SESSION['user_id']);
                $expenses = $balance->getPreviousMonthExpensesBalance($_SESSION['user_id']);
                $expensesSum = $balance->getPreviousMonthExpensesSum($_SESSION['user_id']);

              break;
            case "currentYear":
             

              break;
            case "non_standard_period":
              

                break;
            default:
             
          }


        

        View::renderTemplate('Balance/period.html',[
            'incomes' => $incomes,
            'incomesSum' => $incomesSum,
            'expenses' => $expenses,
            'expensesSum' => $expensesSum
        ]);
        
    } else {

        $this->redirect('/balance/period');
    }
      
            // $this->redirect('/balance/period',[
            //     'incomes' => $incomes
            // ]);
        
    } 

    

}
