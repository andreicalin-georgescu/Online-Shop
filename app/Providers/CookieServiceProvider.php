<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\Cookie\CookieJar;

/**
 * The service provider that handles the
 * interactions with the seesion interface
 */

class CookieServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        CookieJar::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(CookieJar::class, function () use ($container){
            return new CookieJar();
        });
    }
}

 ?>
