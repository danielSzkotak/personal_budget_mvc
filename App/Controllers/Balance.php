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

        //var_dump($incomesSum);

        View::renderTemplate('Balance/period.html',[
            'incomes' => $incomes,
            'incomesSum' => $incomesSum
        ]);
      
            // $this->redirect('/balance/period',[
            //     'incomes' => $incomes
            // ]);
        
    }

    

}
