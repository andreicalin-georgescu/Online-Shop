<?php

use League\Route\Http\Exception\NotFoundException;

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// Load env configuration

try {
    $dotenv = Dotenv\Dotenv::createImmutable(base_path())->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

require_once base_path('/bootstrap/container.php');

$router = $container->get(League\Route\Router::class);

require_once base_path('/bootstrap/middleware.php');

require_once base_path('/routes/web.php');

try {
    $response = $router->dispatch(
        $container->get('request'), $container->get('response')
    );
} catch (Exception $e) {
    $handler = new Shop\Exceptions\Handler(
        $e,
        $container->get(Shop\Session\SessionInterface::class),
        $container->get('response'),
        $container->get(Shop\Views\View::class)
    );

    $response = $handler->respond();
}

 ?>
