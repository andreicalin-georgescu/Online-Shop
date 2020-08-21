<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Auth\Auth;

use Shop\Models\Product;

use Doctrine\ORM\EntityManager;

use League\Route\Router;

/**
 * Controller to interact with the admin operations
 */

class AdminController
{
    protected $db;
    protected $view;
    protected $router;

    public function __construct(EntityManager $db, View $view, Router $router)
    {
        $this->db = $db;
        $this->view = $view;
        $this->router = $router;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'admin/manage.twig', [
            'products' => $this->getAllProducts()
        ]);
    }

    public function addProduct(ServerRequestInterface $request)
    {
        if (isset($_POST['name'], $_POST['price'])) {
            $name = htmlspecialchars($_POST['name']);
            $price = $_POST['price'];

            if (empty($name) || empty($price)) {
                $error = 'All fields are required!';
            } else {
                $newProduct = new Product;
                $newProduct->setName($name);
                $newProduct->setPrice($price);
                $newProduct->setPath('/assets/images');

                $this->addNewProduct($newProduct);
            }
        }

        return redirect($this->router->getNamedRoute('admin.manage')->getPath());
    }

    public function deleteProduct(ServerRequestInterface $request)
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $this->deleteEntry($id);
            return redirect($this->router->getNamedRoute('admin.manage')->getPath());
        }
    }

    protected function addNewProduct(Product $product)
    {
        $this->db->persist($product);
        $this->db->flush();
    }

    protected function deleteEntry($id)
    {
        $product = $this->db->getReference(Product::class, $id);
        $this->db->remove($product);
        $this->db->flush();
    }

    protected function getAllProducts()
    {
        return $this->db->getRepository(Product::class)->findAll();
    }
}

 ?>
