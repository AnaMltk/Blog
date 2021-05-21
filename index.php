<?php
require 'vendor/autoload.php';
session_start();
date_default_timezone_set('Europe/Paris');
$page = $_GET['action']?? 'home/index';
$action = explode('/', $page);
$controller = '\\App\\controller\\'.$action[0].'Controller';
$ctrl = new $controller;
$method = $action[1];
$params = $action[2]??'';
if(method_exists($ctrl, $method)){
    $ctrl->$method($params);
} else {
    echo 'method doesn\'t exist';
    $method = 'add';
    $ctrl->$method();
}
   


