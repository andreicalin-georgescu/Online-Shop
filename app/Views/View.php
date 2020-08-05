<?php

namespace Shop\Views;

use Twig\Environment;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;


/**
 * Wrapper class for view to be able to use
 * inside a controller
 */
class View
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(ResponseInterface $response, $view, $data=[])
    {
        $response->getBody()->write(
            $this->twig->render($view, $data)
        );
        return $response;

    }

    public function share(array $data)
    {
        foreach ($data as $key => $value) {
            $this->twig->addGlobal($key, $value);
        }
    }
}

 ?>
