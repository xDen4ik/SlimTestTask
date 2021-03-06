<?php

use Respect\Validation\Validator as v;
use Respect\Validation\Factory;


session_start();

require  '../vendor/autoload.php';


$app = new \Slim\App(
    [
        'settings' => [
            'displayErrorDetails' => true,
            'db' =>
            [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'twig_test_task',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        ],
    ]
);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};


$container['auth'] = function ($container) {

    return new App\Auth\Auth;
};

$container['flash'] = function ($container) {

    return new Slim\Flash\Messages;
};

$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(
        $_SERVER['DOCUMENT_ROOT'] . '/resources/views',
        [
            'cache' => false,
        ]
    );

    $view->getEnvironment()->addGlobal(
        'auth',
        [
            'check'                     => $container->auth->check(),
            'user'                      => $container->auth->user(),
        ]
    );

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));


    return $view;
};

$container['HomeController'] = function ($container) {

    return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container) {

    return new App\Controllers\Auth\AuthController($container);
};

$container['AdminController'] = function ($container) {

    return new App\Controllers\Admin\AdminController($container);
};


$container['validator'] = function ($container) {

    return new App\Validation\Validator;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleWare($container));
$app->add(new \App\Middleware\OldInputMiddleWare($container));

Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules\\')
        ->withExceptionNamespace('App\\Validation\\Exceptions\\')
);


require $_SERVER['DOCUMENT_ROOT'] . '/app/routes.php';
