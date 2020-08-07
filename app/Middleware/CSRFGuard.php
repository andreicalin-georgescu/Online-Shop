<?php

namespace Shop\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Shop\Security\CSRF;
use Shop\Exceptions\CSRFTokenException;

/**
 * Handles the checking of stored session token
 * against the one that is currently being submitted
 * with the request
 */
class CSRFGuard implements MiddlewareInterface
{
    protected $csrf;

    public function __construct(CSRF $csrf)
    {
        $this->csrf = $csrf;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (!$this->requestRequiresProtection($request)) {
            return $handler->handle($request);
        }

        if (!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
            throw new CSRFTokenException();
        }

        return $handler->handle($request);
    }

    protected function requestRequiresProtection(ServerRequestInterface $request)
    {
        return in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']);
    }
    protected function getTokenFromRequest(ServerRequestInterface $request)
    {
        return $request->getParsedBody()[$this->csrf->key()] ?? NULL;
    }
}

 ?>
