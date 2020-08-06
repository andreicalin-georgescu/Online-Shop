<?php

namespace Shop\Auth\Hashing;

use Shop\Auth\Hashing\HasherInterface;

/**
 *
 */
class DefaultHasher implements HasherInterface
{
    public function create($plain)
    {
        $hash = password_hash($plain, PASSWORD_DEFAULT, $this->options());

        if (!$hash) {
            throw new RuntimeException('Default hashing algorithm not supported.');
        }

        return $hash;
    }

    public function check($plain, $hash)
    {
        return password_verify($plain, $hash);
    }

    public function needsRehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT, $this->options());
    }

    protected function options()
    {
        return [
            'cost' => 12
        ];
    }
}

 ?>
