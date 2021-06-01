<?php

namespace App\controller;

use \App\model\UserManager;
use \App\model\GetPostHelper;
use \App\model\UserModel;

class UserController extends AppController
{

    public function add()
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $userModel = new UserModel();
        $message = '';


        if (null !== ($helper->getPost('register'))) {

            $userModel = new UserModel($_POST);

            $message = $user->add($userModel);
        } else {
            echo 'please enter all information';
        }



        //redirect user on homepage

        $this->view->display('user/registration.html.twig', ['message' => $message, 'user' => $user]);
    }

    public function modifyPassword()
    {
        $password = 'test';
        $userId = '2';
        $userModel = new UserManager();
        $user = $userModel->modifyPassword($password, $userId);
    }

    public function getUser()
    {
        $userId = 2;
        $userModel = new UserManager();
        $user = $userModel->getUser($userId);
    }

    public function logIn()
    {
        $user = new UserManager();
        $helper = new GetPostHelper();
        $error = '';
        $userData = $helper->getUserCredentials();

        if (!empty($userData)) {
            $login = $userData['login'];
            $password = $userData['password'];
        }

        if ($user_id = $user->logIn($login, $password)) {
            
            $_SESSION['userName'] = $login;
            $_SESSION['userId'] = $user_id;
            header('Location: /?action=user/listUsers');
            exit;
        }
        $error = 'wrong password';


        $this->view->display('user/login.html.twig', ['error' => $error]);
    }

    public function logOut()
    {
    }

    public function listUsers()
    {
        $userModel = new UserManager();
        $users = $userModel->listUsers();
        var_dump($_SESSION['userId']);
        $this->view->display('user/userslist.html.twig', ['users' => $users]);
       
    }
}
