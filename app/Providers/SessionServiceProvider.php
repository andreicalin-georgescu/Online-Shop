<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

use Shop\Session\FileSession;
use Shop\Session\SessionInterface;


/**
 * The service provider that handles the
 * interactions with the seesion interface
 */

class SessionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        SessionInterface::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(SessionInterface::class, function () {
            return new FileSession();
        });
    }
}

 ?>
