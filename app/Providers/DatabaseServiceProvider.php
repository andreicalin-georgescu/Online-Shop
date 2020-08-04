<?php

namespace Shop\Providers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;


/**
 * The service provider that handles the
 * interactions with the configuration files
 */

class DatabaseServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $container->share(EntityManager::class, function () use ($config){

            $entityManager = EntityManager::create(
                $config->get('db.' . env('DB_TYPE')),
                Setup::createAnnotationMetadataConfiguration(
                    [base_path('app')],
                    $config->get('app.debug')
                )
            );

            return $entityManager;
        });
    }
}

 ?>
