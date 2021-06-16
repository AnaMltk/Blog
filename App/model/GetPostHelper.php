<?php

namespace App\model;

class GetPostHelper
{

    public function getUserCredentials()
    {
        $login = '';
        $password = '';
        $email = '';
        $userData = [];
        if (isset($_POST['register'])) {

            $login = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userData = [
                'login' => $login,
                'password' => $password,
                'email' => $email,
            ];
        } elseif (isset($_POST['login'])) {
            $login = $_POST['username'];
            $password = $_POST['password'];
            $userData = [
                'login' => $login,
                'password' => $password,
            ];
        }
        return $userData;
    }

    public function getPost($key)
    {
        return $_POST[$key] ?? null;
    }

}
