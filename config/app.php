<?php
    return [
            'name' => env('APP_NAME'),
            'debug' => env('APP_DEBUG', false),

            'providers' => [
                'Shop\Providers\AppServiceProvider',
                'Shop\Providers\ViewServiceProvider',
                'Shop\Providers\DatabaseServiceProvider',
                'Shop\Providers\SessionServiceProvider',
                'Shop\Providers\HashServiceProvider',
                'Shop\Providers\AuthServiceProvider',
                'Shop\Providers\FlashServiceProvider',
                'Shop\Providers\CSRFServiceProvider',
                'Shop\Providers\ValidationServiceProvider',
                'Shop\Providers\PaginationServiceProvider',
                'Shop\Providers\CookieServiceProvider',
                'Shop\Providers\CartServiceProvider',
                'Shop\Providers\ViewShareServiceProvider'
            ],

            'middleware' => [
                'Shop\Middleware\ShareValidationErrors',
                'Shop\Middleware\ClearValidationErrors',
                'Shop\Middleware\Authenticate',
                'Shop\Middleware\AuthenticateFromCookie',
                'Shop\Middleware\CSRFGuard'
            ]
    ];
 ?>
