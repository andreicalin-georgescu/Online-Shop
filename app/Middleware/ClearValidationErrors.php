<?php

namespace Shop\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Shop\Session\SessionInterface;

/**
 * Middleware class to clear login validation errors after each request
 */
class ClearValidationErrors implements MiddlewareInterface
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $this->session->clear('errors', 'old');

        return $handler->handle($request);
    }
}

 ?>
