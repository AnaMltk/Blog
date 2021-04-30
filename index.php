<?php
require 'vendor/autoload.php';
session_start();
$page = $_GET['action']?? 'home/index';
$action = explode('/', $page);
$controller = '\\App\\controller\\'.$action[0].'Controller';
$ctrl = new $controller;
$method = $action[1];
$ctrl->$method();

//$user = new \App\controller\UserController();
//$user->add();
//$user->getUser();
//$user->logIn();
//$user->listUsers();
//$user->modifyPassword();
