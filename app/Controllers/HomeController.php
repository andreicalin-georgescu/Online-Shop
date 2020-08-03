<?php

namespace Shop\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;

/**
 * Controller to interact with the homepage
 *
 * @param \Psr\Http\Message\ServerRequestInterface $request
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

class HomeController
{

    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;
        $response->getBody()->write('<h1>Home Page</h1>');
        return $response;
    }
}

 ?>
