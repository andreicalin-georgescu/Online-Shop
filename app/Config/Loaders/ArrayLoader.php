<?php

namespace Shop\Config\Loaders;

use Exception;
use Shop\Config\Loaders\LoaderInterface;

/**
 * Array Loader class for passing configuration
 */
class ArrayLoader implements LoaderInterface
{
    protected $files;

    function __construct(array $files)
    {
        $this->files = $files;
    }

    public function parse()
    {
        $parsed = [];

        foreach ($this->files as $namespace => $path) {
            try {
                $parsed[$namespace] = require $path;
            } catch (Exception $e) {
                //
            }

        }

        return $parsed;
    }
}

 ?>
