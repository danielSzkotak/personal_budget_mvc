<?php

namespace App\Controllers;

use App\Auth;
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
    public function balanceAction()
    {

        View::renderTemplate('Balance/balance.html');
    }

    

}
