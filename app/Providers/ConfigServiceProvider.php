<?php

namespace Shop\Providers;

use Shop\Config\Config;
use Shop\Config\Loaders\ArrayLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;


/**
 * The service provider that handles the
 * interactions with the configuration files
 */

class ConfigServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'config'
    ];

    public function register()
    {
        $this->getContainer()->share('config', function () {
            $loader = new ArrayLoader([
                'app' => base_path('config/app.php'),
                'cache' => base_path('config/cache.php'),
            ]);

            return (new Config)->load([$loader]);
            
        });


    }
}

 ?>
