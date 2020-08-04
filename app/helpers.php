<?php
    /*
     * Base URL helper
     * @return {string} path A path starting from the root directory
     */

     if (!function_exists('base_path')) {
         function base_path($path ='') {
             return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
         }
     }

     /*
      * Custom env function to retrieve a certain
      * config value
      */

      if (!function_exists('env')) {
          function env($key, $default = NULL) {
              if (!isset($_SERVER[$key])) {
                  return $default;
              }

              $value = $_SERVER[$key];

              switch (strtolower($value)) {
                  case $value === 'true':
                      return true;

                  case $value === 'false':
                      return false;

                  default:
                      return $value;
              }
          }

      }


 ?>
