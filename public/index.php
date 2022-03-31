<?php

/**
 * Front controller
 *
 */

 

/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Twig
 */



/**
 * Error and Exception handling
 */
error_reporting(E_ALL); 
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('addIncome', ['controller' => 'Income', 'action' => 'addIncome']);
$router->add('{controller}/{action}');

    
$router->dispatch($_SERVER['QUERY_STRING']);
