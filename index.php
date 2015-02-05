<?php
session_cache_limiter(false);
session_start();

require './vendor/autoload.php';

require './init.php';

$Controller = new \Stemer\Controller();
$secure = new \Stemer\Security();

$app->get('/',$secure->isLogin(), $Controller->DashBoard() );

$app->get('/people' , $secure->isLogin(),$Controller->People() );



$app->post('/login',  $Controller->PostLogin() );

$app->get('/login', $Controller->LoginForm());

$app->get('/logout',$Controller->LogOut() );



$app->run();
?>