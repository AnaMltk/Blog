<?php

namespace App\model;

use \App\model\UserModel;

class UserManager extends Manager
{
    public function hydrate($login, $email, $password)
    {
        $userModel = new UserModel();
        $userModel->setUserName($login);
        $userModel->setUserEmail($email);
        $userModel->setUserPassword($password);
        return $userModel;
        
    }

    public function add($user)
    {
        $user = new UserModel;
        
       // if (filter_var($userModel->getUserEmail(), FILTER_VALIDATE_EMAIL) && preg_match("/[A-Za-z0-9]+/", $userModel->getUserName())) {
            $users = $this->dbConnect()->prepare('INSERT INTO user (login, password, email, role) VALUES (:login, :password, :email, :role)');
            $users->execute([':login' => $user->getUserName(), ':password' => $user->getUserPassword(), ':email' => $user->getUserEmail(), ':role' => 1]);
            
       // } else {
         //   echo 'Please enter valid email';
       // }
    }

    public function modifyPassword($password, $userId)
    {
        $statement = $this->db->prepare('UPDATE user SET password = ? WHERE user_id = ?');
        $user = $statement->execute(array($password, $userId));
        return $user;
    }

    public function getUser($userId)
    {
        $statement = $this->db->prepare('SELECT login, email, role FROM user WHERE user_id = ?');
        $statement->execute(array($userId));
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function getCredentials($email)
    {
        $statement = $this->db->prepare('SELECT password FROM user WHERE email = ?');
        $statement->execute(array($email));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listUsers()
    {
        $statement = $this->db->prepare('SELECT user_id, login, email, role FROM user ORDER BY user_id DESC');
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }
    
    public function logIn($email, $password){
        $hash = password_hash($this->getCredentials($email), PASSWORD_BCRYPT);
        if(password_verify($password, $hash)){
            echo 'You have logged in';
        } else {
            echo 'Wrong email or passsword';
        }
        
    }

}
