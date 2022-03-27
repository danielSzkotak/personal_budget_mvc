<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\User;

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
        View::renderTemplate('Income/addIncome.html');
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
