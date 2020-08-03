<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;

/**
 * Controller to interact with the homepage
 *
 * @param \Psr\Http\Message\ServerRequestInterface $request
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

class HomeController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;
        return $this->view->render($response, 'home.twig', []);
    }
}

 ?>
