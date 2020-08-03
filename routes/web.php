<?php

use Shop\Controllers\HomeController;

//$router = new League\Route\Router;

//$router->map('GET', '/', [Shop\Controllers\HomeController::class, 'index'])->setName('home');
$router->get('/', function ($request, $response) use ($container) {
    return (new HomeController($container->get(Shop\Views\View::class)))->index($request, $response);
})->setName('home');
 ?>
