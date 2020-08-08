<?php

namespace Shop\Auth;

use Doctrine\ORM\EntityManager;
use Shop\Models\User;
use Shop\Auth\Recaller;
use Shop\Auth\Hashing\HasherInterface;
use Shop\Session\SessionInterface;
use Exception;

use Shop\Cookie\CookieJar;

/**
 * Authentication class to handle user actions
 */
class Auth
{
    protected $db;
    protected $hasher;
    protected $session;
    protected $user;
    protected $recaller;
    protected $cookie;

    public function __construct(
        EntityManager $db,
        HasherInterface $hash,
        SessionInterface $session,
        Recaller $recaller,
        CookieJar $cookie
    ) {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
    }
    public function logout()
    {
        $this->session->clear($this->key());
    }
    public function attempt($username, $password, $remember = false)
    {
        $user = $this->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password) ) {
            return false;
        }

        if ($this->needsRehash($user)) {
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }

        return true;
    }

    public function setUserFromCookie()
    {
        list($identifier, $token) = $this->recaller->splitCookieValue(
            $this->cookie->get('remember')
        );

        $user = $this->db->getRepository(User::class)->findOneBy([
            'remember_identifier' => $identifier
        ]);

        if (!$user) {
            $this->cookie->clear('remember');
            return;
        }

        if (!$this->recaller->validateToken($token, $user->remember_token)) {
            $user = $this->db->getRepository(User::class)->find($user->id)->update([
                'remember_identifier' => NULL,
                'remember_token' => NULL
            ]);

            $this->db->flush();
            $this->cookie->clear('remember');

            throw new Exception();
        }

        $this->setUserSession($user);

    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
    }

    protected function setRememberToken($user)
    {
        list($identifier, $token) = $this->recaller->generate();

        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

        $this->db->getRepository(User::class)->find($user->id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $this->recaller->getTokenHashForDatabase($token)
        ]);

        $this->db->flush();
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
        $this->user = $user;
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
