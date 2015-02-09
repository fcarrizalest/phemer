<?php
session_cache_limiter(false);
session_start();

require './vendor/autoload.php';

require './init.php';

$Controller = new \Stemer\Controller();
$secure = new \Stemer\Security();

$app->get('/',$secure->isLogin(), $Controller->DashBoard() );



$app->get('/people' , $secure->isLogin(), $secure->checkPermission("administer users") ,$Controller->People() );
$app->post('/people' , $secure->isLogin(), $secure->checkPermission("administer users") ,$Controller->PostNewUser() );
$app->get('/people/new' ,$secure->isLogin(), $secure->checkPermission("administer users") , $Controller->NewUser() );
$app->get('/people/:id/edit', $secure->isLogin(), $secure->checkPermission("administer users") ,  $Controller->EditUser()   );
$app->post('/people/:id' , $secure->isLogin(), $secure->checkPermission("administer users") , $Controller->PostEditUser() );
$app->post('/people/:id/delete' , $secure->isLogin(), $secure->checkPermission("administer users") , $Controller->PostDeleteUser() );





$app->post('/login',  $Controller->PostLogin() );
$app->get('/login', $Controller->LoginForm());
$app->get('/logout',$Controller->LogOut() );


$app->run();
?>