<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Auth\Auth;

/**
 * Controller to interact with the homepage
 */

class HomeController
{
    protected $view;

    public function __construct(View $view, Auth $auth)
    {
        $this->view = $view;
        $this->auth = $auth;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'home.twig', [
            'user' => $this->auth->user(),
        ]);
    }
}

 ?>
