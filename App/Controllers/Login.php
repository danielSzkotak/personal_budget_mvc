<?php

namespace App\Controllers;

use App\Auth;
use App\Flash;
use \Core\View;
use \App\Models\User;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the login page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html');
    }

    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
   
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if ($user) {

            Auth::login($user);
            $this->redirect(Auth::getReturnToPage());

        } else {

            Flash::addMessage('Logowanie nie powiodło się, spróbuj jeszcze raz', Flash::WARNING);
            View::renderTemplate('Login/new.html', [
                'email' => $_POST['email'],
            ]);
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
        $this->redirect('/login/show-logout-message');
        
    }

    public function showLogoutMessageAction(){

        Flash::addMessage('Wylogowano prawidłowo');
        $this->redirect('/login');
    }
}
