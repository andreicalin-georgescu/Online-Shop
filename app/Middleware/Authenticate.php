<?php

namespace Shop\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Exception;
use Shop\Auth\Auth;

/**
 * Middleware class to clear login validation errors after each request
 */
class Authenticate implements MiddlewareInterface
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if ($this->auth->hasUserInSession()) {
            try {
                $this->auth->setUserFromSession();
            } catch (Exception $e) {
                // $this->auth->logout
            }

        }
        return $handler->handle($request);
    }
}

 ?>
