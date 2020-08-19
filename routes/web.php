<?php

use Shop\Controllers\HomeController;
use Shop\Controllers\Auth\LoginController;
use Shop\Controllers\Auth\LogoutController;
use Shop\Controllers\Auth\RegistrationController;
use Shop\Controllers\ProductController;
use Shop\Controllers\DashboardController;

use Shop\Middleware\Authenticated;
use Shop\Middleware\Guest;

$router->get('/', HomeController::class . '::index')->setName('home');
$router->group('', function ($router) {
    $router->get('/dashboard', DashboardController::class . '::index')->setName('dashboard');
    $router->post('/auth/logout', LogoutController::class . '::logout')->setName('auth.logout');
})->middleware($container->get(Authenticated::class));

$router->group('/auth', function ($router) {
    $router->get('/signin', LoginController::class . '::index')->setName('auth.login');
    $router->post('/signin', LoginController::class . '::signin');

    $router->get('/register', RegistrationController::class . '::index')->setName('auth.register');
    $router->post('/register', RegistrationController::class . '::register');
})->middleware($container->get(Guest::class));

$router->get('/products', ProductController::class . '::index')->setName('products');
 ?>
