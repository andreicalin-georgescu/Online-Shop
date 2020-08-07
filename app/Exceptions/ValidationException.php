<?php

namespace Shop\Exceptions;

use Exception;

    /**
     * Class to define the exception thrown when form
     * verifications fail
     */
    class ValidationException extends Exception
    {
        public function __construct($request, array $errors)
        {
            $this->request = $request;
            $this->errors = $errors;
        }

        public function getPath()
        {
            return $this->request->getUri()->getPath();
        }

        public function getOldInput()
        {
            return $this->request->getParsedBody();
        }

        public function getErrors()
        {
            return $this->errors;
        }
    }

 ?>
