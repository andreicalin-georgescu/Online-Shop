<?php

namespace Shop\Cookie;

/**
 *
 */
class CookieJar
{
    protected $path = '/';
    protected $domain = NULL;
    protected $secure = false;
    protected $httpOnly = true;

    public function set($name, $value, $minutes = 60)
    {
        $expiry = time() + ($minutes * 60);

        setcookie(
            $name, $value, $expiry,
            $this->path, $this->domain, $this->secure, $this->httpOnly
        );
    }

    public function get($key, $default = NULL)
    {
        if ($this->exists($key)) {
            return $_COOKIE[$key];
        }

        return $default;
    }

    public function exists($key)
    {
        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
    }

    public function clear($key)
    {
        $this->set($key, NULL, -2628000, $this->path, $this->domain);
    }
    
    public function forever($key, $value)
    {
        $this->set($key, $value, 2628000)
    }
}

 ?>
