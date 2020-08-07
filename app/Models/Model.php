<?php

namespace Shop\Models;

/**
 * Abstract model class with a get magic method
 */
abstract class Model
{
    public function __get($name)
    {
        if(property_exists($this, $name)) {
            return $this->{$name};
        }
    }

    public function __isset($name)
    {
        if(property_exists($this, $name)) {
            return true;
        }

        return false;
    }
}

 ?>
