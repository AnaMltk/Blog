<?php
require ('controller/UserController.php');
$user = new UserController();
//$user->add();
$user->getUser();
$user->logIn();
$user->listUsers();
$user->modifyPassword();
