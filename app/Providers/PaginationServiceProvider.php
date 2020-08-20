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

            if (!in_array('pageSize', $container->get('request')->getQueryParams())) {
                $pageSize = 3;
            } else {
                $pageSize = $container->get('request')->getQueryParams()['pageSize'];
            }

            return new PaginatorHelper(
                $container->get(EntityManager::class),
                $pageSize,
                'price'
            );
        });
    }
}

 ?>
