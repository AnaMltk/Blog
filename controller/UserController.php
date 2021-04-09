<?php

require('model/UserModel.php');
class UserController
{

    public function add()
    {
        $login = 'firstUser';
        $password = 'fdqjhkjshdjg';
        $email = 'test1@gmail.com';
        $role = 1;
        $user = new UserModel();
        $newUser = $user->add($login, $password, $email, $role);
        var_dump($newUser);
    }

    public function modifyPassword()
    {
        $password = 'test';
        $userId = '2';
        $userModel = new UserModel();
        $user = $userModel->modifyPassword($password, $userId);
    }

    public function getUser()
    {
        $userId = 2;
        $userModel = new UserModel();
        $user = $userModel->getUser($userId);
        var_dump($user);
    }

    public function logIn()
    {
        $user = new UserModel();

        $password = 'fdqjhkjshdjg';
        $email = 'test@gmail.com';

        $credentials = $user->getCredentials($email);

        if (in_array($password, $credentials)) {
            echo 'You have logged in successfully';
        } else {
            echo 'wrong password';
        }
    }

    public function logOut()
    {
    }

    public function listUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->listUsers();
        var_dump($users);
    }
}
