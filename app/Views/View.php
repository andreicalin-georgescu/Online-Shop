<?php

namespace Shop\Views;

use Twig\Environment;

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
        return $response->getBody()->write('<h1>Home Page</h1>');
    }
}

 ?>
