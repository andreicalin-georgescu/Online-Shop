<?php

$container = new League\Container\Container;

// Use autowiring for the Container

$container->delegate(
    new League\Container\ReflectionContainer
);

$container->addServiceProvider(new Shop\Providers\ConfigServiceProvider());

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider($provider);
}

 ?>
