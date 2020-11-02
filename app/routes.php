<?php


$app->get('/', 'HomeController:main')->setName('main');

//Home page
$app->get('/auth', 'HomeController:index')->setName('home');

//SignUp page
$app->get('/auth/signup', 'AuthController:getSignUp')->setName('outh.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

//SignIn page
$app->get('/auth/signin', 'AuthController:getSignIn')->setName('outh.signin');
$app->post('/auth/signin', 'AuthController:postSignIn');

//SignOut
$app->get('/auth/signout', 'AuthController:getSignOut')->setName('outh.signout');

//admin users
$app->get('/admin/users', 'AdminController:getUsers')->setName('admin.users');
$app->get('/admin/edit/{id:[0-9]+}', 'AdminController:getUser')->setName('admin.edit');
$app->post('/update', 'AdminController:updateUser')->setName('admin.update');

//admin logs
$app->get('/admin/logs', 'AdminController:getUsersLogs')->setName('admin.logs');