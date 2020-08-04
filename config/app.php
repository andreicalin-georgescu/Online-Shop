<?php
    return [
            'name' => env('APP_NAME'),
            'debug' => env('APP_DEBUG', false),

            'providers' => [
                'Shop\Providers\AppServiceProvider',
                'Shop\Providers\ViewServiceProvider',
                'Shop\Providers\DatabaseServiceProvider'
            ]
    ];
 ?>
