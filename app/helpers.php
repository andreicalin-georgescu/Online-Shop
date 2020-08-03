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
 ?>
