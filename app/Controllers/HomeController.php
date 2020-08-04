<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response;
use Shop\Views\View;
use Shop\Models\User;

/**
 * Controller to interact with the homepage
 */

class HomeController
{
    protected $view;

    public function __construct(View $view, EntityManager $db)
    {
        $this->view = $view;
        $this->db = $db;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        $user = $this->db->getRepository(User::class)->find(1);

        return $this->view->render($response, 'home.twig', [
            'user' => $user
        ]);
    }
}

 ?>
