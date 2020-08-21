<?php

namespace Shop\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Shop\Auth\Auth;

/**
 * Middleware class to check if a user has admin priviliges
 */
class Administrator implements MiddlewareInterface
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (!$this->auth->isAdmin()) {
            return new RedirectResponse('/');
        }
        return $handler->handle($request);
    }
}

 ?>
