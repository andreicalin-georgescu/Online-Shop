<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

use Shop\Session\Flash;
use Shop\Session\SessionInterface;

/**
 * The service provider that handles the
 * interactions with the seesion interface
 */

class FlashServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Flash::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(Flash::class, function () use ($container){
            return new Flash(
                $container->get(SessionInterface::class)
            );
        });
    }
}

 ?>
