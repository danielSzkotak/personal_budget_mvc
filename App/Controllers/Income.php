<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Models\Income_model;


/**
 * Login controller
 *
 * PHP version 7.0
 */
class Income extends Authenticated {

    /**
     * Show the addIncome page
     *
     * @return void
     */
    public function addIncomeAction()
    {
        
        $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
        $_SESSION['income_cat'] = $incomeCat;

        View::renderTemplate('Income/addIncome.html');
    }

    /**
     * Add income
     *
     * @return void
     */
    public function addAction()
    {
   
        if(isset($_POST["submitIncome"])){

            $_SESSION['income_submitted'] = true;

            //Format incom Data
            $amount = number_format($_POST["incomeAmount"], 2, '.', ',');
            $date = date("d-m-Y", strtotime($_POST["incomeDate"]));
            $categoryFetch = explode('|', $_POST["incomeCategory"]);
            $categoryID = $categoryFetch[0];
            $categoryName = $categoryFetch[1];

            $income = new Income_model($amount, $_POST["incomeDate"], $categoryID, $_SESSION['user_id']);
            $income->addIncome();
            
            View::renderTemplate('Income/addIncome.html', [
                'income_amount' => $amount.' zł',
                'income_date' => $date,
                'income_cat' => $categoryName
            ]);

            unset( $_SESSION['income_submitted']);
        }
    }

}
