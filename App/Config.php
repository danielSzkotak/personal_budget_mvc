<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'personalbudget';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'user';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'secret';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

     /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = '5diGM3uejXlPYxTck0Pfh0cnfnwq8ypl';
}
