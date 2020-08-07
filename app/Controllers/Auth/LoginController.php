<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Controllers\Controller;
use Shop\Auth\Auth;
use League\Route\Router;

/**
 * Controller to interact with the Login
 */

class LoginController extends Controller
{
    protected $view;
    protected $auth;
    protected $router;

    public function __construct(
        View $view,
        Auth $auth,
        Router $router
    ) {
        $this->view = $view;
        $this->auth = $auth;
        $this->router = $router;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'auth/login.twig');
    }

    public function signin($request)
    {
        $userInput = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($userInput['email'], $userInput['password']);

        if (!$attempt) {
            var_dump('failed');
            die();
        }

        return redirect($this->router->getNamedRoute('home')->getPath());
    }
}

 ?>
