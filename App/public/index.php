<?php
require __DIR__ . '/../../vendor/autoload.php';

session_set_cookie_params(600, '/', $_SERVER['HTTP_HOST'], false, true);
session_start();
date_default_timezone_set('Europe/Paris');
$page = $_GET['action'] ?? 'homepage/home';
$action = explode('/', $page);
$controller = '\\App\\controller\\' . $action[0] . 'Controller';
$ctrl = new $controller;
$method = $action[1];
$params = $action[2] ?? '';
if (method_exists($ctrl, $method)) {
    $ctrl->$method($params);
} else {
    $method = 'add';
    $ctrl->$method();
}