<?php

$container = new League\Container\Container;

// Use autowiring for the Container

$container->delegate(
    new League\Container\ReflectionContainer
);

$container->addServiceProvider(new Shop\Providers\AppServiceProvider());
$container->addServiceProvider(new Shop\Providers\ViewServiceProvider());
$container->addServiceProvider(new Shop\Providers\ConfigServiceProvider());

 ?>
