<?php

namespace App\Controllers;

class HomeController extends Controller
{

    public function index($request, $response)
    {
        return $this->view->render($response, 'home.twig');
    }

    public function main($request, $response)
    {
        return $response->withRedirect($this->router->pathfor('home'));
    }
}
