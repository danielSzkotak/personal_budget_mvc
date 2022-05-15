<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Serviceable;


/**
 * Login controller
 *
 * PHP version 7.0
 */
class Profile extends Authenticated {

    /**
     * Show the addIncome page
     *
     * @return void
     */
    public function showProfileAction()
    {
        
        // $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
        // $_SESSION['income_cat'] = $incomeCat;

        View::renderTemplate('Profile/profile.html');
    }

    /**
     * Add income
     *
     * @return void
     */
    public function addCategoryAction()
    {
   
        if(isset($_POST["submitIncome"])){

            $_SESSION['income_submitted'] = true;

            $amount = Serviceable::formatAmountToModal($_POST["incomeAmount"]);
            $date = Serviceable::formatDateToModal($_POST["incomeDate"]);
            $categoryID = Serviceable::fetchIDFromOptionValue($_POST["incomeCategory"]);
            $categoryName = Serviceable::fetchNameFromOptionValue($_POST["incomeCategory"]);

            $income = new Income_model($_POST["incomeAmount"], $_POST["incomeDate"], $categoryID, $_SESSION['user_id']);
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
