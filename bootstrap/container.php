<?php

$container = new League\Container\Container;

$container->addServiceProvider(new Shop\Providers\AppServiceProvider());
$container->addServiceProvider(new Shop\Providers\ViewServiceProvider());

 ?>
