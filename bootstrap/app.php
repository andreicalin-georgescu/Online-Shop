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

$loader = new Shop\Config\Loaders\ArrayLoader([
    'app' => base_path('config/app.php'),
    'cache' => base_path('config/cache.php'),
]);

var_dump($loader->parse());
die();

require_once base_path('/bootstrap/container.php');

$router = $container->get(League\Route\Router::class);

require_once base_path('/routes/web.php');

$response = $router->dispatch(
    $container->get('request'), $container->get('response')
);

 ?>
