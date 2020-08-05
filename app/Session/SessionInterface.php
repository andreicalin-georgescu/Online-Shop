<?php

namespace Shop\Session;

/**
 * Contract to outline the basic methods of a session handler
 */
interface SessionInterface
{
    public function get($key, $default=NULL);
    public function set($key, $value=NULL);
    public function exists($key);
    public function clear(...$key);
}


 ?>
