<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Valitron\Validator;

use Shop\Rules\ExistsRule;

use Doctrine\ORM\EntityManager;

/**
 * The service provider that handles the
 * validation different application-wide rules
 */

class ValidationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Validator::addRule('exists', function ($field, $value, $params, $fields) {
            $rule = new ExistsRule($this->getContainer()->get(EntityManager::class));
            return $rule->validate($field, $value, $params, $fields);
        }, 'is already in use');
    }

}

 ?>
