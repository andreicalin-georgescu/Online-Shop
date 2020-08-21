<?php

namespace Shop\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Shop\ShoppingCart\Cart;

/**
 * The service provider that handles the
 * interactions with the shopping cart
 */

class CartServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Cart::class
    ];

    public function register()
    {
        $container = $this->getContainer();

        $container->share(Cart::class, function () {
            $options = [
                'cartMaxItem' => 0,
                'itemMaxQuantity' => 99,
                'useCookie' => false,
            ];

            return new Cart($options);
        });
    }
}

 ?>
