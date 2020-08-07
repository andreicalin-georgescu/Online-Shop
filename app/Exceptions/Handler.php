<?php

namespace Shop\Exceptions;

use Exception;
use ReflectionClass;

use Laminas\Diactoros\Response;
use Shop\Exceptions\CSRFTokenException;
use Shop\Exceptions\ValidationException;

use Shop\Session\SessionInterface;

use Shop\Views\View;

/**
 * Handler class to deal with exceptions
 */
class Handler
{
    protected $exception;
    protected $session;
    protected $view;
    protected $response;

    public function __construct(
        Exception $exception,
        SessionInterface $session,
        Response $response,
        View $view
    ){
        $this->exception = $exception;
        $this->session = $session;
        $this->view = $view;
        $this->response = $response;
    }

    public function respond()
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    protected function handleValidationException(ValidationException $e)
    {
        $this->session->set([
            'errors' => $e->getErrors(),
            'old' => $e->getOldInput()
        ]);
        return redirect($e->getPath());
    }

    protected function handleCSRFTokenException(CSRFTokenException $e)
    {
        return $this->view->render($this->response, 'errors/csrf.twig');
    }

    protected function unhandledException(Exception $e)
    {
        throw $e;
    }
}

 ?>
