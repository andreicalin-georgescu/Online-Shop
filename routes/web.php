<?php

use Shop\Controllers\HomeController;
use Shop\Controllers\Auth\LoginController;
use Shop\Controllers\Auth\LogoutController;
use Shop\Controllers\Auth\RegistrationController;


$router->get('/', HomeController::class . '::index')->setName('home');

$router->group('/auth', function ($router) {
    $router->get('/signin', LoginController::class . '::index')->setName('auth.login');
    $router->post('/signin', LoginController::class . '::signin');

    $router->post('/logout', LogoutController::class . '::logout')->setName('auth.logout');
    $router->get('/register', RegistrationController::class . '::index')->setName('auth.register');
    $router->post('/register', RegistrationController::class . '::register');
});
 ?>
