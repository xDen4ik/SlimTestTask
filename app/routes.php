<?php

//Home page
$app->get('/', 'HomeController:index')->setName('home');

//SignUp page
$app->get('/auth/signup', 'AuthController:getSignUp')->setName('outh.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');