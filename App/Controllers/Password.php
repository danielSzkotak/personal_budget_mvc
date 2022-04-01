<?php

namespace App\Controllers;

use Core\View;

class Password extends \Core\Controller{

   /**
    * Show forgotten password page
    */

    public function forgotAction(){

      View::renderTemplate('Password/forgot.html');
    }
}