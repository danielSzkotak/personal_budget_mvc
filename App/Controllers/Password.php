<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

class Password extends \Core\Controller{

   /**
    * Show forgotten password page
    */

    public function forgotAction(){

      View::renderTemplate('Password/forgot.html');
    }

    public function requestResetAction(){

      User::sendPasswordReset($_POST['email']);
      View::renderTemplate('Password/reset_requested.html');
    }
    
    public function resetAction(){

      $token = $this->route_params['token'];

      $user = $this->getUserOrExit($token);

      View::renderTemplate('Password/reset.html',[
        'token' => $token
      ]);
    }

    public function resetPasswordAction(){

      $token = $_POST['token'];

      $user = $this->getUserOrExit($token);

      if($user->resetPassword($_POST['password'])){

        View::renderTemplate('Password/reset_success.html');

      } else {

        View::renderTemplate('Password/reset.html',[
          'token' => $token,
          'user' => $user
        ]);

      }

    }

    /**
     * Find the user model assosiated with the password reset token or end the request with a message
     */
    protected function getUserOrExit($token){

      $user = User::findByPasswordReset($token);
      
      if($user){

        return $user;

      } else {

        View::renderTemplate('Password/token_expired.html');
        exit;
      }
    }

}