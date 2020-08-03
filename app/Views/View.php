<?php

namespace Shop\Views;

use Twig\Environment;
use Laminas\Diactoros\Response;


/**
 * Wrapper class for view to be able to use
 * inside a controller
 */
class View
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render($response)
    {
        $response = new Response;
        $response->getBody()->write('<h1>Home Page</h1>');
        return $response;
    }
}

 ?>
