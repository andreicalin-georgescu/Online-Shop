<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Doctrine\ORM\EntityManager;

use Shop\Views\View;
use Shop\Pagination\PaginatorHelper;

use Shop\ShoppingCart\Cart;

use League\Route\Router;

/**
 * Controller to interact with the products page
 */
class ProductController
{
    protected $db;
    protected $view;
    protected $paginator;
    protected $cart;

    public function __construct(
        EntityManager $db,
        View $view,
        PaginatorHelper $paginator,
        Cart $cart,
        Router $router
    ) {
        $this->db = $db;
        $this->view = $view;
        $this->paginator = $paginator;
        $this->cart = $cart;
        $this->router = $router;
    }

    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        $this->paginator->setPageSize($request);
        $this->paginator->setFilter($request);
        $this->paginator->setCurrentPage($request);
        $this->paginator->setSorting($request);

        return $this->view->render($response, 'products.twig', [
            'products' => $this->paginator->getRecords(),
            'pager' => $this->paginator->getDisplayParameters()
        ]);

    }
    public function addToCart(ServerRequestInterface $request)
    {
        $id = $request->getParsedBody()['id'];
        $name = $request->getParsedBody()['name'];
        $price = $request->getParsedBody()['price'];

        $this->cart->add($id, $name, $price);

        return redirect($this->router->getNamedRoute('products')->getPath());
    }
}

 ?>
