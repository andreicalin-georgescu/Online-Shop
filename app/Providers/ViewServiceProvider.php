<?php

namespace Shop\Providers;

use Twig_Loader_Filesystem;
use Twig_Environment;
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

        $container->share(View::class, function () {
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');

            $twig = new \Twig\Environment($loader,[
                'cache' => false
            ]);

            return new View($twig);
        });




    }
}

 ?>
