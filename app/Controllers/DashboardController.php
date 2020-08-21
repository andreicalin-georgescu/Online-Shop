<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Auth\Auth;

use Shop\ShoppingCart\Cart;

use League\Route\Router;

/**
 * Controller to interact with the user dashboard
 */

class DashboardController
{
    protected $view;
    protected $cart;
    protected $router;

    public function __construct(View $view, Cart $cart, Router $router)
    {
        $this->view = $view;
        $this->cart = $cart;
        $this->router = $router;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'dashboard/index.twig', [
            'cart' => $this->cart
        ]);
    }

    public function removeFromCart(ServerRequestInterface $request)
    {
        $id = $request->getParsedBody()['id'];
        $this->cart->remove($id);

        return redirect($this->router->getNamedRoute('dashboard')->getPath());

    }
}

 ?>
