<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{

    //Render view
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    //Get data 
    public function postSignUp($request, $response)
    {

        $validation = $this->validator->validate(
            $request,
            [
                'first_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                'last_name' => v::noWhitespace()->notEmpty()->length(1, 20),
                'email' => v::email(),
                'password' => v::noWhitespace()->notEmpty()->length(5, null),
            ]
        );

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathfor('outh.signup'));
        }

        User::create([
            'first_name'    => $request->getParam('first_name'),
            'last_name'     => $request->getParam('last_name'),
            'email'         => $request->getParam('email'),
            'password'      => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
        ]);
        return $response->withRedirect($this->router->pathfor('home'));
    }

    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }
}
