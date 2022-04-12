<?php

namespace App;

class Serviceable
{

   public static function formatDateToModal($value)
   {

      $date = date("d-m-Y", strtotime($value));
      return $date;
   }

   public static function formatAmountToModal($value)
   {

      $amount = number_format($value, 2, '.', ' ');
      return $amount;
   }

   public static function fetchIDFromOptionValue($value)
   {

      $stringFetch = explode('|', $value);
      $ID = $stringFetch[0];
      return $ID;
   }

   public static function fetchNameFromOptionValue($value)
   {

      $stringFetch = explode('|', $value);
      $name = $stringFetch[1];
      return $name;
   }

   public static function formatAmountToView($array)
   {
      foreach ($array as $row => &$innerArray) {
         foreach ($innerArray as $key => &$value) {
            if ($key == 'category_sum' || $key == 'total') {
               $value = number_format((float)$value, 2, '.', ' ');
            }
         }
      }
      return $array;
   }
}
