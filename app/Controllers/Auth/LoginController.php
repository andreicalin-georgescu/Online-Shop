<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Controllers\Controller;

/**
 * Controller to interact with the Login
 */

class LoginController extends Controller
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

    public function signin($request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    }
}

 ?>
