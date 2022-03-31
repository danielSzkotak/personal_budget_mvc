<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
       
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        if (Auth::getUser()){

            View::renderTemplate('/Income/addIncome.html');

        } else {

            View::renderTemplate('Home/index.html');
            
        }
        
    }
}
