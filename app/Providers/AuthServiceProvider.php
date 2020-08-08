<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\Auth\Auth;
use Shop\Auth\Recaller;
use Shop\Auth\Hashing\HasherInterface;
use Shop\Session\SessionInterface;

use Shop\Cookie\CookieJar;
use Shop\Auth\Exposers\DatabaseExposer;

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
            $exposer = new DatabaseExposer(
                $container->get(EntityManager::class)
            );

            return new Auth(
                $container->get(HasherInterface::class),
                $container->get(SessionInterface::class),
                new Recaller(),
                $container->get(CookieJar::class),
                $exposer
            );
        });
    }

}

 ?>
