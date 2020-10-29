<?php

namespace App\Controllers;
use App\Models\User;

class HomeController extends Controller
{

    public function index($request, $response)
    {

        $user = User::create([
            'first_name'    => "Den",
            'last_name'     => "TOP",
            'email'         => "cool.den0@yandex.ru",
            'password'      => "global"
        ]);
       
        var_dump($user);
        die();
        return $this->view->render($response, 'home.twig');
    }
}
