<?php
require __DIR__ . '/../../vendor/autoload.php';

session_set_cookie_params(600, '/', $_SERVER['HTTP_HOST'], false, true);
session_start();
date_default_timezone_set('Europe/Paris');
$page = 'blog/public/homepage/home';
if(!empty($_GET['action'])){
    $page = $_GET['action'];
}

$action = explode('/', $page);

$controller = '\\App\\controller\\' . $action[2] . 'Controller';


$ctrl = new $controller;
$method = $action[3];
$params = $action[4] ?? '';
if (method_exists($ctrl, $method)) {
    $ctrl->$method($params);
} else {
    $method = 'index';
    $ctrl->$method();
}
