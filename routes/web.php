<?php

use Shop\Controllers\HomeController;


$router->get('/', HomeController::class . '::index')->setName('home');
 ?>
