<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

/**
 * Signup controller
 */
class Signup extends \Core\Controller
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

    }

    /**
     * Show the page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    //**Sign up a new user**/

    public function createAction(){

        $user = new User($_POST);
           
        if($user->save()){

            $user->sendActivationEmail();
            $user->copyCategories($user->getIdByEmail($user->email));
            $this->redirect('/signup/success');
            
        } else {
            View::renderTemplate('Home/index.html',[
                'user' => $user
            ]);
        }
    }

    public function successAction(){

        View::renderTemplate('Signup/success.html');
    }

    public function activateAction(){

        User::activate($this->route_params['token']);
        $this->redirect('/signup/activated');
    }


    public function activatedAction(){

        Flash::addMessage('Dziękujemy za aktywacje!, możesz się bezpiecznie zalogować');       
        $this->redirect('/login/new');
    }

   

   
}
