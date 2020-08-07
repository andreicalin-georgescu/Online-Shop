<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Controllers\Controller;
use Shop\Auth\Auth;
use Shop\Session\Flash;
use League\Route\Router;

/**
 * Controller to interact with the Login
 */

class LoginController extends Controller
{
    protected $view;
    protected $auth;
    protected $router;
    protected $flash;

    public function __construct(
        View $view,
        Auth $auth,
        Router $router,
        Flash $flash
    ) {
        $this->view = $view;
        $this->auth = $auth;
        $this->router = $router;
        $this->flash = $flash;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'auth/login.twig');
    }

    public function signin(ServerRequestInterface $request)
    {
        $userInput = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($userInput['email'], $userInput['password']);

        if (!$attempt) {
            $this->flash->now('error', 'Could not sign you in with those credentials.');
            return redirect($request->getUri()->getPath());
        }

        return redirect($this->router->getNamedRoute('home')->getPath());
    }
}

 ?>
