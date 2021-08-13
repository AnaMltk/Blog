<?php
require __DIR__ . '/../../vendor/autoload.php';
if(!defined('WWW')){
    define('WWW', __DIR__);
}
session_set_cookie_params(600, '/', $_SERVER['HTTP_HOST'], false, true);
session_start();
date_default_timezone_set('Europe/Paris');

$page = $_SERVER['REQUEST_URI'];

if($page == '/'){
    $page = 'blog/index.php/Homepage/home';
}
if(!empty($_GET['action'])){
    $page = $_GET['action'];
}

$action = explode('/', $page);
$controller = ucwords(strtolower($action[2]));
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
