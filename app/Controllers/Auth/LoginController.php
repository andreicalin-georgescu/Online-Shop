<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;

/**
 * Controller to interact with the homepage
 */

class LoginController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'auth/login.twig');
    }
}

 ?>
