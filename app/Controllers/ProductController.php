<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Doctrine\ORM\EntityManager;

use Shop\Views\View;
use Shop\Pagination\PaginatorHelper;

/**
 * Controller to interact with the products page
 */
class ProductController
{
    protected $db;
    protected $view;
    protected $paginator;

    public function __construct(EntityManager $db, View $view, PaginatorHelper $paginator)
    {
        $this->db = $db;
        $this->view = $view;
        $this->paginator = $paginator;
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
}

 ?>
