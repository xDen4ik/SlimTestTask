<?php

namespace App\Middleware;

class ValidationErrorsMiddleWare extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!empty($_SESSION['errors'])) {
            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        }

        unset($_SESSION['errors']);

        $response = $next($request, $response);

        return $response;
    }
}
