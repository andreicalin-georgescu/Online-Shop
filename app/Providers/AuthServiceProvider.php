<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\Auth\Auth;
use Shop\Auth\Hashing\HasherInterface;
use Shop\Session\SessionInterface;
use Doctrine\ORM\EntityManager;

/**
 * The service provider that handles the
 * authentication of users
 */

class AuthServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        Auth::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(Auth::class, function () use ($container){
            return new Auth(
                $container->get(EntityManager::class),
                $container->get(HasherInterface::class),
                $container->get(SessionInterface::class)
            );
        });
    }

}

 ?>
