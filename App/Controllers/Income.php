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

        View::renderTemplate('Income/addIncome.html', [
            'income_categories' => $incomeCat
        ]); 
    }

    /**
     * Add income
     *
     * @return void
     */
    public function createAction()
    {
   
        // $user = User::authenticate($_POST['email'], $_POST['password']);

        // if ($user) {

        //     Auth::login($user);

        //     View::renderTemplate('AddIncome/addIncome.html');
        //     // $this->redirect('/');

        // } else {

        //     View::renderTemplate('Login/new.html', [
        //         'email' => $_POST['email'],
        //     ]);
        // }
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
