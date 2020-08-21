<?php

namespace Shop\Auth;

use Shop\Models\User;
use Shop\Auth\Recaller;
use Shop\Auth\Hashing\HasherInterface;
use Shop\Auth\Exposers\DatabaseExposer;
use Shop\Session\SessionInterface;
use Shop\Cookie\CookieJar;
use Exception;

/**
 * Authentication class to handle user actions
 */
class Auth
{
    protected $hash;
    protected $session;
    protected $user;
    protected $exposer;
    protected $recaller;
    protected $cookie;
    protected $isAdmin = NULL;

    public function __construct(
        HasherInterface $hash,
        SessionInterface $session,
        Recaller $recaller,
        CookieJar $cookie,
        DatabaseExposer $exposer
    ) {
        $this->hash = $hash;
        $this->session = $session;
        $this->recaller = $recaller;
        $this->cookie = $cookie;
        $this->exposer = $exposer;
    }

    public function logout()
    {
        $this->exposer->clearUserRememberToken($this->user->id);
        $this->cookie->clear('remember');
        $this->session->clear($this->key());
    }

    public function attempt($username, $password, $remember = false)
    {
        $user = $this->exposer->getByUsername($username);

        if (!$user || !$this->hasValidCredentials($user, $password) ) {
            return false;
        }

        if ($this->isAdmin === NULL) {
            $this->isAdmin = $user->is_admin;
        }

        if ($this->needsRehash($user)) {
            $this->exposer->updateUserPasswordHash($user->id, $this->hash->create($password));
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

        if (!$user = $this->exposer->getUserByRememberIdentifier($identifier)) {
            $this->cookie->clear('remember');
            return;
        }

        $this->user = $user;

        if (!$this->recaller->validateToken($token, $user->remember_token)) {
            $this->exposer->clearUserRememberToken($user->id);
            $this->cookie->clear('remember');

            throw new Exception();
        }

        $this->setUserSession($user);

    }

    public function hasRecaller()
    {
        return $this->cookie->exists('remember');
    }

    public function isAdmin()
    {
        return $this->exposer->isAdmin($this->user->id);
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
        $user = $this->exposer->getById($this->session->get($this->key()));

        if (!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }

    protected function setRememberToken($user)
    {
        list($identifier, $token) = $this->recaller->generate();

        $this->cookie->set('remember', $this->recaller->generateValueForCookie($identifier, $token));

        $this->exposer->setUserRememberToken(
            $user->id, $identifier, $this->recaller->getTokenHashForDatabase($token)
        );
    }

    protected function needsRehash($user)
    {
        return $this->hash->needsRehash($user->password);
    }

    protected function setUserSession($user)
    {
        $this->session->set($this->key(), $user->id);
        $this->user = $user;
    }

    protected function key()
    {
        return 'id';
    }

    protected function hasValidCredentials($user, $password)
    {
        return $this->hash->check($password, $user->password);
    }

}

 ?>
