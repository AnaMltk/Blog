<?php

namespace App\model;

use \App\model\UserModel;

class UserManager extends Manager
{

    public function add($user)
    {

        $password = \password_hash($user->getUserPassword(), PASSWORD_BCRYPT);

        $error = [];
        if (!filter_var($user->getUserEmail(), FILTER_VALIDATE_EMAIL)) {

            $error[] = 'please enter valid email';
        }
        if (!preg_match("/[A-Za-z0-9]+/", $user->getUserName())) {

            $error[] = 'please enter valid login';
        }

        $emailQuery = $this->getDb()->prepare('SELECT email FROM user WHERE email = ?');
        $emailQuery->execute(array($user->getUserEmail()));
        $existantEmail = $emailQuery->fetch(\PDO::FETCH_ASSOC);

        if (!empty($existantEmail)) {

            $error[] = 'Email already exists';
        }

        if ($error) {
            return $error;
        }
        $users = $this->getDb()->prepare('INSERT INTO user (login, password, email, role) VALUES (:login, :password, :email, :role)');

        $users->execute([':login' => $user->getUserName(), ':password' => $password, ':email' => $user->getUserEmail(), ':role' => 1]);
    }

    public function modifyPassword($password, $token)
    {
        $password = \password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->getDb()->prepare('UPDATE user SET password = :password WHERE token = :token');
        $statement->execute([':password'=>$password, ':token'=>$token]);
        $statement = $this->getDb()->prepare('UPDATE user SET token = null WHERE token = :token');
        $statement->execute([':token'=>$token]);
        
    }

    public function getTokenForPasswordReset($email)
    {
        $statement = $this->getDb()->prepare('SELECT email FROM user WHERE email = ?');
        $statement->execute(array($email));
       
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        
        $token = '';
        if (!empty($result)) {
            $token = bin2hex(random_bytes(50));
        }
        
        $statement = $this->getDb()->prepare('UPDATE user SET token =:token WHERE email = :email');
        $statement->execute([':token'=>$token, ':email'=>$email]);
        
        return $token;
    }

    public function getUser($userId)
    {
        $statement = $this->getDb()->prepare('SELECT user_id, login, email, role FROM user WHERE user_id = ?');
        $statement->execute(array($userId));
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function getCredentials($email)
    {
        $statement = $this->getDb()->prepare('SELECT user_id, password FROM user WHERE email = ?');
        $statement->execute(array($email));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listUsers()
    {
        $statement = $this->getDb()->prepare('SELECT user_id, login, email, role FROM user ORDER BY user_id DESC');
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }

    public function logIn($email, $password)
    {

        $credentials = $this->getCredentials($email);
        if (!$credentials) {
            return false;
        }

        $checkPassword = password_verify($password, $credentials['password']);
        if (!$checkPassword) {
            return false;
        }
        if (password_needs_rehash($password, PASSWORD_BCRYPT)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $user = $this->getDb()->prepare('UPDATE user SET password = :password WHERE user_id = :user_id');
            $user->execute([':password' => $hash, ':user_id' => $credentials['user_id']]);
        }
        return $credentials['user_id'];
    }

    
}
