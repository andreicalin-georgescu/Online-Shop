<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

use Shop\Views\View;
use Shop\Auth\Auth;
use Shop\Session\Flash;


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
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class),
            'flash' => $container->get(Flash::class),
        ]);
    }
}

 ?>
