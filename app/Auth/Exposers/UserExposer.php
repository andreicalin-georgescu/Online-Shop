<?php

namespace Shop\Auth\Exposers;

/**
 * Contract to specify what methods a user exposure
 * should make available for use in Auth class
 */
interface UserExposer
{
    public function getByUsername($username);
    public function getById($id);
    public function updateUserPasswordHash($id, $hash);
    public function getUserByRememberIdentifier($identifier);
    public function clearUserRememberToken($id);
    public function setUserRememberToken($id, $identifier, $hash);
}

 ?>
