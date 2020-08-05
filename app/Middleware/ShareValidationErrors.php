<?php

namespace Shop\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Shop\Views\View;
use Shop\Session\SessionInterface;

/**
 * Middleware class to share login validation errors
 */
class ShareValidationErrors implements MiddlewareInterface
{
    protected $view;
    protected $session;

    public function __construct(View $view, SessionInterface $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $this->view->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old', [])
        ]);

        return $handler->handle($request);
    }
}

 ?>
