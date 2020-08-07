<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use League\Route\Router;

use Shop\Controllers\Controller;
use Shop\Auth\Auth;

/**
 * Controller to interact with the loggin out of users
 */

class LogoutController extends Controller
{
    protected $auth;
    protected $router;

    public function __construct(Auth $auth, Router $router)
    {
        $this->auth = $auth;
        $this->router = $router;
    }

    public function logout(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        $this->auth->logout();

        return redirect($this->router->getNamedRoute('home')->getPath());

    }
}

 ?>
