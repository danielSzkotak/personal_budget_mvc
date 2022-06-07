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
$router->add('addExpense', ['controller' => 'Expense', 'action' => 'addExpense']);
$router->add('period', ['controller' => 'Balance', 'action' => 'period']);
$router->add('balance', ['controller' => 'Balance', 'action' => 'balance']);
$router->add('profile', ['controller' => 'Profile', 'action' => 'showProfile']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('{controller}/{action}');

//------------------API------------------
$router->add('api/limit/{id:[\da-f]+}', ['controller' => 'Expense', 'action' => 'categoryLimit']);

    
$router->dispatch($_SERVER['QUERY_STRING']);
