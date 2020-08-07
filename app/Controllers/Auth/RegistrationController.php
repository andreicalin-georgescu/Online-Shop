<?php

namespace Shop\Controllers\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response;
use League\Route\Router;

use Shop\Views\View;
use Shop\Controllers\Controller;
use Shop\Models\User;
use Shop\Auth\Auth;
use Shop\Auth\Hashing\HasherInterface;

/**
 * Controller to interact with the signup process
 */

class RegistrationController extends Controller
{
    protected $view;
    protected $hash;
    protected $router;
    protected $db;
    protected $auth;

    public function __construct(
        View $view,
        HasherInterface $hash,
        Router $router,
        EntityManager $db,
        Auth $auth
    ) {
        $this->view = $view;
        $this->hash = $hash;
        $this->router = $router;
        $this->db = $db;
        $this->auth = $auth;
    }
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $response = new Response;

        return $this->view->render($response, 'auth/register.twig');
    }

    public function register(ServerRequestInterface $request)
    {
        $data = $this->validateRegistration($request);

        $user = $this->createUser($data);

        if (!$this->auth->attempt($data['email'], $data['password'])) {

            // if the sign in fails redirect to homepage without login

            return redirect($this->router->getNamedRoute('home')->getPath());
        }

        return redirect($this->router->getNamedRoute('home')->getPath());
    }

    protected function createUser($data)
    {
        $user = new User;

        // Simple XSS protection

        $data['name'] = htmlspecialchars($data['name']);

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hash->create($data['password'])
        ]);

        $this->db->persist($user);
        $this->db->flush();

        return $user;
    }

    protected function validateRegistration(ServerRequestInterface $request)
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}

 ?>
