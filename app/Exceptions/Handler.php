<?php

namespace Shop\Exceptions;

use Exception;
use ReflectionClass;
use Shop\Exceptions\ValidationException;

use Shop\Session\SessionInterface;

/**
 * Handler class to deal with exceptions
 */
class Handler
{
    protected $exception;
    protected $session;

    public function __construct(
        Exception $exception,
        SessionInterface $session
    ){
        $this->exception = $exception;
        $this->session = $session;
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

    protected function unhandledException(Exception $e)
    {
        throw $e;
    }
}

 ?>
