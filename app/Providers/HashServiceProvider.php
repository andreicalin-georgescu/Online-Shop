<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\Auth\Hashing\DefaultHasher;
use Shop\Auth\Hashing\HasherInterface;

/**
 * The service provider that handles the
 * hashing of user given passwords
 */

class HashServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        HasherInterface::class
    ];

    public function register()
    {
        $this->getContainer()->share(HasherInterface::class, function () {
            return new DefaultHasher;
        });
    }

}

 ?>
