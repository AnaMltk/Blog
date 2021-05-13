<?php
require 'vendor/autoload.php';
session_start();
$page = $_GET['action']?? 'home/index';
$action = explode('/', $page);
$controller = '\\App\\controller\\'.$action[0].'Controller';
$ctrl = new $controller;
$method = $action[1];
if(method_exists($ctrl, $method)){
    $ctrl->$method();
} else {
    echo 'method doesn\'t exist';
    $method = 'add';
    $ctrl->$method();
}
   



//$user = new \App\controller\UserController();
//$user->add();
//$user->getUser();
//$user->logIn();
//$user->listUsers();
//$user->modifyPassword();
