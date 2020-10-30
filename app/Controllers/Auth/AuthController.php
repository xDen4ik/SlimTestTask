<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;


class AuthController extends Controller
{

    public function getSignUp($request, $response)
    {

        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp($request, $response)
    {
        User::create([
            'first_name'    => $request->getParam('first_name'),
            'last_name'     => $request->getParam('last_name'),
            'email'         => $request->getParam('email'),
            'password'      => password_hash($request->getParam('pswd'), PASSWORD_DEFAULT)
        ]);
        return $response->withRedirect($this->router->pathfor('home'));
    }
}
