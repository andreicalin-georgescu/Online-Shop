<?php

namespace Shop\Providers;

use Shop\Views\View;
use Shop\Views\Extensions\PathExtension;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;


/**
 * The service provider that handles the
 * interactions with the Twig views
 */

class ViewServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        View::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $container->share(View::class, function () use ($config, $container) {
            $loader = new \Twig\Loader\FilesystemLoader(base_path('views'));

            $twig = new \Twig\Environment($loader,[
                'cache' => $config->get('cache.views.path'),
                'debug' => $config->get('app.debug')
            ]);

            if ($config->get('app.debug')) {
                $twig->addExtension(new \Twig\Extension\DebugExtension);
            }

            $twig->addExtension(new PathExtension($container->get(Router::class)));

            return new View($twig);
        });




    }
}

 ?>
