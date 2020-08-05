<?php

    foreach ($container->get('config')->get('app.middleware') as $middleware) {
        $router->middleware($container->get($middleware));
    }
 ?>
