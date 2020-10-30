<?php

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
