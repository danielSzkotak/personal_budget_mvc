<?php

namespace App\Controllers;

/**
 * Authenticated base controller
 * 
 */

 abstract class Authenticated extends \Core\Controller{
    
    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before(){
        
      $this->requireLogin();
  }
 }