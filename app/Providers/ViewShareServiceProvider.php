<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

use Shop\Views\View;


/**
 * The service provider that handles the
 * sharing of variables between Twig views
 */

class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $container = $this->getContainer();
        $container->get(View::class)->share([
            'config' => $container->get('config')
        ]);
    }
}

 ?>
