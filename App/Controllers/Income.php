<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;

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

        // View::renderTemplate('Income/addIncome.html', [
        //     'income_categories' => $incomeCat
        // ]); 

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

            //Format incoem Data
            $amount = number_format($_POST["incomeAmount"], 2, '.', ',');
            $amount = $amount . ' zł';
            $date = date("d-m-Y", strtotime($_POST["incomeDate"]));
            $categoryFetch = explode('|', $_POST["incomeCategory"]);
            //$categoryID = $categoryFetch[0];
            $categoryName = $categoryFetch[1];
            
            View::renderTemplate('Income/addIncome.html', [
                'income_amount' => $amount,
                'income_date' => $date,
                'income_cat' => $categoryName
            ]);

            unset( $_SESSION['income_submitted']);
        }
    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {

        Auth::logout();
        $this->redirect('/');
    }

}
