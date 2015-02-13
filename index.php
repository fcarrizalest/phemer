<?php
session_cache_limiter(false);
session_start();

require './vendor/autoload.php';

require './init.php';

$Controller = new \Stemer\Controller();

$UserController = new \Stemer\Controllers\UserController();

$secure = new \Stemer\Security();

$app->get('/',$secure->isLogin(), $Controller->DashBoard() );



$app->get('/people' , $secure->isLogin(), $secure->checkPermission("administer users") ,$UserController->People() );
$app->post('/people' , $secure->isLogin(), $secure->checkPermission("administer users") ,$UserController->PostNewUser() );
$app->get('/people/new' ,$secure->isLogin(), $secure->checkPermission("administer users") , $UserController->NewUser() );
$app->get('/people/:id/edit', $secure->isLogin(), $secure->checkPermission("administer users") ,  $UserController->EditUser()   );
$app->post('/people/:id' , $secure->isLogin(), $secure->checkPermission("administer users") , $UserController->PostEditUser() );
$app->post('/people/:id/delete' , $secure->isLogin(), $secure->checkPermission("administer users") , $UserController->PostDeleteUser() );



$app->get('/people/roles' , $secure->isLogin(), $secure->checkPermission("administer permissions") ,$Controller->Roles() );
$app->get('/people/permissions' , $secure->isLogin(), $secure->checkPermission("administer permissions") ,$Controller->Permissions() );




$app->post('/login',  $Controller->PostLogin() );
$app->get('/login', $Controller->LoginForm());
$app->get('/logout',$Controller->LogOut() );


$app->run();



?>