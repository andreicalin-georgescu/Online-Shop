<?php

namespace Shop\Providers;

use Shop\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;


/**
 * The service provider that handles the
 * interactions with the twig views
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

        $container->share(View::class, function () use ($config) {
            $loader = new \Twig\Loader\FilesystemLoader(base_path('views'));

            $twig = new \Twig\Environment($loader,[
                'cache' => $config->get('cache.views.path'),
                'debug' => $config->get('app.debug')
            ]);

            if ($config->get('app.debug')) {
                $twig->addExtension(new \Twig\Extension\DebugExtension);
            }


            return new View($twig);
        });




    }
}

 ?>
