<?php

namespace Shop\Auth;

use Doctrine\ORM\EntityManager;
use Shop\Models\User;
use Shop\Auth\Hashing\HasherInterface;
use Shop\Session\SessionInterface;
use Exception;

/**
 * Authentication class to handle user actions
 */
class Auth
{
    protected $db;
    protected $hasher;
    protected $session;
    protected $user;

    public function __construct(EntityManager $db, HasherInterface $hash, SessionInterface $session)
    {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
    }
    public function attempt($username, $password)
    {
        $user = $this->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password) ) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);

        return true;
    }

    protected function needsRehash($user)
    {
        return $this->hash->needsRehash($user->password);
    }

    protected function rehashPassword($user, $password)
    {
        $this->db->getRepository(User::class)->find($user->id)->update([
            'password' => $this->hash->create($password)
        ]);

        $this->db->flush();
    }
    public function user()
    {
        return $this->user;
    }

    public function check()
    {
        return $this->hasUserInSession();
    }

    public function hasUserInSession()
    {
        return $this->session->exists($this->key());
    }

    public function setUserFromSession()
    {
        $user = $this->getById($this->session->get($this->key()));
        if (!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }

    protected function setUserSession($user)
    {
        $this->session->set($this->key(), $user->id);
    }

    protected function key()
    {
        return 'id';
    }

    protected function hasValidCredentials($user, $password)
    {
        return $this->hash->check($password, $user->password);
    }

    protected function getById($id)
    {
        return $this->db->getRepository(User::class)->find($id);
    }

    protected function getByUsername($username)
    {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
    }
}

 ?>
