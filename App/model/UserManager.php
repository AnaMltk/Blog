<?php

namespace App\model;


class UserManager extends Manager
{

    /**
     * @param UserModel $user
     * 
     * @return void
     */
    public function add(UserModel $user): void
    {

        $users = $this->getDb()->prepare('INSERT INTO user (user_name, user_password, user_email, role) VALUES (:login, :password, :email, :role)');

        $users->execute([':login' => $user->getUserName(), ':password' => $user->getUserPassword(), ':email' => $user->getUserEmail(), ':role' => 0]);
    }

    /**
     * @param string $password
     * @param string $token
     * 
     * @return string
     */
    public function modifyPassword(string $password, string $token): string
    {
       
        $statement = $this->getDb()->prepare('UPDATE user SET user_password = :password WHERE token = :token');
        $statement->execute([':password' => $password, ':token' => $token]);
        $statement = $this->getDb()->prepare('UPDATE user SET token = null WHERE token = :token');
        $statement->execute([':token' => $token]);
        return 'Votre mot de passe a été modifié avec succés';
    }

    /**
     * @param string $token
     * @param string $email
     * 
     * @return void
     */
    public function getTokenForPasswordReset(string $token, string $email): void
    {
        $statement = $this->getDb()->prepare('UPDATE user SET token =:token WHERE user_email = :email');
        $statement->execute([':token' => $token, ':email' => $email]);
    }

    /**
     * @param int $userId
     * 
     * @return UserModel
     */
    public function getUser(int $userId): UserModel
    {

        $userModel = new UserModel();
        $statement = $this->getDb()->prepare('SELECT user_id, user_name, user_password, user_email, role, token FROM user WHERE user_id = ?');
        $statement->execute(array($userId));
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        $userModel->hydrate($user);
        return $userModel;
    }

    /**
     * @param string $email
     * 
     * @return array
     */
    public function getCredentials(string $email): array
    {
        $statement = $this->getDb()->prepare('SELECT user_id, user_password FROM user WHERE user_email = ?');
        $statement->execute(array($email));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @return array
     */
    public function listUsers(): array
    {
        $statement = $this->getDb()->prepare('SELECT user_id, user_name, user_email, role FROM user ORDER BY user_id DESC');
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $userList = [];
        foreach ($users as $user) {
            $userModel = new UserModel();
            $userModel->hydrate($user);
            $userList[] = $userModel;
        }
        return $userList;
    }


    /**
     * @param string $email
     * @param string $password
     * 
     * @return int
     */
    public function logIn(int $userId, string $password): int
    {
        $user = $this->getDb()->prepare('UPDATE user SET password = :password WHERE user_id = :user_id');
        $user->execute([':password' => $password, ':user_id' => $userId]);
        return $userId;
    }

    public function getExistingEmail($user)
    {
        $emailQuery = $this->getDb()->prepare('SELECT user_email FROM user WHERE user_email = ?');
        $emailQuery->execute(array($user->getUserEmail()));
        $existantEmail = $emailQuery->fetch(\PDO::FETCH_ASSOC);
        return $existantEmail;
    }
}
