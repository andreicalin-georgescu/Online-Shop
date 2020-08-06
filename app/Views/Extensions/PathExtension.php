<?php

namespace Shop\Views\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use League\Route\Router;

/**
 * Custom extension to
 */
class PathExtension extends AbstractExtension
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'route'])
        ];
    }

    public function route($name)
    {
        return $this->router->getNamedRoute($name)->getPath();
    }
}

 ?>
