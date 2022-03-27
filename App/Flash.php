<?php

namespace App;


/**
 * Flash notification messages
 * 
 */

 class Flash{

  /**
   * Messages types
   */

   const SUCCESS = 'success';
   const INFO = 'info';
   const WARNING = 'warning';


   /**
    * Add a message
    */

      public static function addMessage($message, $type = 'success'){

          //Create array in the session if it doesnt exist
          if(! isset($_SESSION['flash_notification'])){
            $_SESSION['flash_notification'] = [];
          }

          //Append the message to the array
          $_SESSION['flash_notification'][] = [
            'body' =>  $message,
            'type' => $type
          ];
         
      }

      /**
       * Get all the messages
       */

       public static function getMessages(){

         if(isset($_SESSION['flash_notification'])){

            $messages = $_SESSION['flash_notification'];
            unset($_SESSION['flash_notification']);
            return $messages;
           //return $_SESSION['flash_notification'];
         }
       }
 }