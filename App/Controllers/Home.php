<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use App\Models\Categories;

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

            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $_SESSION['income_cat'] = $incomeCat;
            View::renderTemplate('/Income/addIncome.html');

        } else {

            View::renderTemplate('Home/index.html');
            
        }
        
    }
}
