<?php

session_start();

require  '../vendor/autoload.php';


$app = new \Slim\App(
    [
        'settings' => [
            'displayErrorDetails' => true,
        ]
    ]
);

$container = $app->getContainer();

$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(
        __DIR__ . '/../resources/views',
        [
            'cache' => false,
        ]
    );

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['HomeController'] = function ($container) {

    return new App\Controllers\HomeController($container->view);
};


require __DIR__ . '/../app/routes.php';
