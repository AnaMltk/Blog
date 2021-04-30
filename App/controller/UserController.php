<?php

namespace App\controller;

use \App\model\UserManager;
use \App\model\UserModel;

class UserController extends AppController
{

    public function add()
    {
        $user = new UserManager();
        

        $message = '';
        $login = '';
        $email = '';
        $password = '';
        if (isset($_POST['register'])) {

            $login = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userModel = $user->hydrate($login, $email, $password);
        var_dump($userModel); 
            $message = $user->add($userModel);
        }
        
        
        //redirect user on homepage


        /*  $login = 'secondUser';
        $password = 'jhdkjshkjhf';
        $email = 'test2@gmail.com';*/

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
        var_dump($user);
    }

    public function logIn()
    {
        $user = new UserManager();

        $password = 'fdqjhkjshdjg';
        $email = 'test@gmail.com';

        $credentials = $user->getCredentials($email);
        $error = '';
        if (in_array($password, $credentials)) {
            echo 'You have logged in successfully';
        } else {
            $error = 'wrong password';
        }
        $this->view->display('user/login.html.twig', ['error' => $error]);
    }

    public function logOut()
    {
    }

    public function listUsers()
    {
        $userModel = new UserManager();
        $users = $userModel->listUsers();
        $this->view->display('user/userslist.html.twig', ['users' => $users]);
        /*foreach ($users as $user) {
            $userId = $user['user_id'];
            $login = $user['login'];
            $email = $user['email'];
            $role = $user['role'];
           
        }*/
    }
}
