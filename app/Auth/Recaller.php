<?php

namespace Shop\Auth;

/**
 * Handles the remember functionality of the application
 */
class Recaller
{
    protected $separator = '|';

    public function generate()
    {
        return [$this->generateIdentifier(), $this->generateToken()];
    }

    protected function generateIdentifier()
    {
        return bin2hex(random_bytes(32));
    }

    public function splitCookieValue($value)
    {
        return explode($this->separator, $value);
    }

    public function validateToken($plain, $hashed)
    {
        return $this->getTokenHashForDatabase($plain) === $hashed;
    }

    protected function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    public function generateValueForCookie($identifier, $token)
    {
        return $identifier . $this->separator . $token;
    }
    public function getTokenHashForDatabase($token)
    {
        return hash('sha256', $token);
    }
}

 ?>
