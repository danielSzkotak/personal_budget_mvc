<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Balance_model;
use App\Models\Categories;
use App\Serviceable;
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

                //$detailedIncomes = $balance->getCurrentMonthDetailedIncomes($_SESSION['user_id']);
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

                $incomes = $balance->getCurrentYearIncomesBalance($_SESSION['user_id']);
                $incomesSum = $balance->getCurrentYearIncomesSum($_SESSION['user_id']);
                $expenses = $balance->getCurrentYearExpensesBalance($_SESSION['user_id']);
                $expensesSum = $balance->getCurrentYearExpensesSum($_SESSION['user_id']);
             

              break;
            case "non_standard_period":
              
                $incomes = $balance->getCustomDatesIncomesBalance($_SESSION['user_id'], $_POST['startDate'], $_POST['endDate']);
                $incomesSum = $balance->getCustomDatesIncomesSum($_SESSION['user_id'], $_POST['startDate'], $_POST['endDate']);
                $expenses = $balance->getCustomDatesExpensesBalance($_SESSION['user_id'], $_POST['startDate'], $_POST['endDate']);
                $expensesSum = $balance->getCustomDatesExpensesSum($_SESSION['user_id'], $_POST['startDate'], $_POST['endDate']);

                break;
            default:
             
          }

          $periods = array (
            "currentMonth" => "Bieżący miesiąc",
            "previousMonth" => "Poprzedni miesiąc",
            "currentYear" => "Bieżący rok",
            "non_standard_period" => "Wybrany okres"
          );

         

          if($incomesSum[0]['total'] == NULL && $expensesSum[0]['total'] == NULL){
            $balanceSum = NULL;
          } else {
            $balanceSum = $incomesSum[0]['total'] - $expensesSum[0]['total'];
            $balanceSum = Serviceable::formatAmountToModal($balanceSum);
          }

          //$incomes = Serviceable::formatAmountToView($incomes);
          $incomesSum = Serviceable::formatAmountToView($incomesSum);
          //$expenses = Serviceable::formatAmountToView($expenses);
          $expensesSum = Serviceable::formatAmountToView($expensesSum);


        View::renderTemplate('Balance/period.html',[
            'incomes' => $incomes,
            //'detailedIncomes' => $detailedIncomes,
            'incomesSum' => $incomesSum,
            'expenses' => $expenses,
            'expensesSum' => $expensesSum,
            'periods' => $periods,
            'balancePeriod' => $balancePeriod,
            'balanceSum' => $balanceSum,
            'startDate' => $_POST['startDate'],
            'endDate' => $_POST['endDate']
        ]);

        
        
    } else {

        $this->redirect('/balance/period');
    }
      
    } 

    

}
