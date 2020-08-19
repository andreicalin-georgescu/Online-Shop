<?php

namespace Shop\Providers;

use Shop\Pagination\PaginatorHelper;
use League\Container\ServiceProvider\AbstractServiceProvider;

use Doctrine\ORM\EntityManager;


/**
 * The service provider that handles the
 * pagination of Twig views
 */

class PaginationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        PaginatorHelper::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(PaginatorHelper::class, function () use ($container) {

            return new PaginatorHelper(
                $container->get(EntityManager::class),
                3,
                'price'
            );
        });
    }
}

 ?>
