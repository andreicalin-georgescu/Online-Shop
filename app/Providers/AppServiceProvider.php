<?php

namespace Shop\Providers;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

/**
 * The service provider that handles the
 * interactions with the application
 */

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Router::class,
        'request',
        'response',
        'emitter'
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(Router::class, function () use ($container) {
            $strategy = (new ApplicationStrategy)->setContainer($container);
            return (new Router)->setStrategy($strategy);
        });

        $container->share('response', Response::class);

        $container->share('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        });

        $container->share('emitter', function () {
            return new SapiEmitter;
        });
    }
}

 ?>
