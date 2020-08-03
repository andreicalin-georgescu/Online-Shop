<?php

use Shop\Controllers\HomeController;

//$router = new League\Route\Router;

//$router->map('GET', '/', [Shop\Controllers\HomeController::class, 'index'])->setName('home');
$router->get('/', HomeController::class . '::index')->setName('home');
 ?>
