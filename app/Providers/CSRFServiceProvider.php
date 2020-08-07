<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\Security\CSRF;

use Shop\Session\SessionInterface;

/**
 * The service provider that handles the
 * protection agains XSS attacks
 */

class CSRFServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        CSRF::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(CSRF::class, function () use ($container) {
            return new CSRF(
                $container->get(SessionInterface::class)
            );
        });
    }

}

 ?>
