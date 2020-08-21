<?php

namespace Shop\Auth\Exposers;

use Shop\Auth\Exposers\UserExposer;

use Shop\Models\User;

use Doctrine\ORM\EntityManager;
/**
 * Exposes methods for interacting with the database
 * inside Auth class
 */
class DatabaseExposer implements UserExposer
{
    protected $db;

    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }
    public function isAdmin($id)
    {
        $user = $this->db->getRepository(User::class)->find($id);
        return $user->is_admin;
    }
    public function getByUsername($username){
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
    }
    public function getById($id){
        return $this->db->getRepository(User::class)->find($id);
    }
    public function updateUserPasswordHash($id, $hash){
        $this->db->getRepository(User::class)->find($id)->update([
            'password' => $hash
        ]);

        $this->db->flush();
    }
    public function getUserByRememberIdentifier($identifier){
        return $this->db->getRepository(User::class)->findOneBy([
            'remember_identifier' => $identifier
        ]);
    }
    public function clearUserRememberToken($id){
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => NULL,
            'remember_token' => NULL
        ]);

        $this->db->flush();
    }
    public function setUserRememberToken($id, $identifier, $hash)
    {
        $this->db->getRepository(User::class)->find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $hash
        ]);

        $this->db->flush();
    }
}

 ?>
