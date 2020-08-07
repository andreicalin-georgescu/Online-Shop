<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Auth\Auth;

use Shop\Cookie\CookieJar;

/**
 * Controller to interact with the homepage
 */

class HomeController
{
    protected $view;

    public function __construct(View $view, CookieJar $cookie)
    {
        $this->view = $view;
        $this->cookie = $cookie;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        $this->cookie->clear('abc');

        return $this->view->render($response, 'home.twig');
    }
}

 ?>
