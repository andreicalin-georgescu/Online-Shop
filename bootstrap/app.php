<?php

use League\Route\Http\Exception\NotFoundException;

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

require_once __DIR__ . '/container.php';

$router = $container->get(League\Route\Router::class);

require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch(
    $container->get('request'), $container->get('response')
);

 ?>
