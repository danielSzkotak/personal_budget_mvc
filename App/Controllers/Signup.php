<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

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

            $user->copyCategories();  
            $_SESSION['username'] = $user->username;        
            $this->redirect('/login/new');
            //exit;
            
        } else {
            View::renderTemplate('Home/index.html',[
                'user' => $user
            ]);
        }
    }

   
}
