<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Auth\Auth;

/**
 * Controller to interact with the user dashboard
 */

class DashboardController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'dashboard/index.twig');
    }
}

 ?>
