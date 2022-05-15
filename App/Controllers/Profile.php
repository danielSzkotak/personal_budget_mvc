<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Models\Profile_model;
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
        
        $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
        $_SESSION['income_cat'] = $incomeCat;
     
        View::renderTemplate('Profile/profile.html',[
            'income_cat' => $incomeCat
        ]);
    }

    /**
     * Add income
     *
     * @return void
     */
    public function editCategoryNameAction()
    {
   
        if(isset($_POST["submitCategory"])){


            $category = new Profile_model($_POST);
            $category->updateIncomeCategoryName();
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat
            ]);

        }
    }

}
