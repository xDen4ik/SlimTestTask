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
        if (!empty($this->auth->check())) {
            return $response->withRedirect($this->router->pathfor('home'));
        }
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

  

        $this->auth->attempt($request->getParam('email'), $request->getParam('password'));

        return $response->withRedirect($this->router->pathfor('home'));
    }


    //Render view login 
    public function getSignIn($request, $response)
    {
        if (!empty($this->auth->check())) {
            return $response->withRedirect($this->router->pathfor('home'));
        }
        return $this->view->render($response, 'auth/signin.twig');
    }

    //Login data
    public function postSignIn($request, $response)
    {
        //check
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'Oops. It looks like you were wrong!');  
            return $response->withRedirect($this->router->pathfor('outh.signin'));
        }
       
        $this->flash->addMessage('success', 'You have been signed up!');  

        return $response->withRedirect($this->router->pathfor('home'));
    }


    public function getSignOut($request, $response)
    {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathfor('home'));
    }
}
