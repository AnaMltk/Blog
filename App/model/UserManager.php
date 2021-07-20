<?php

namespace App\model;


class UserManager extends Manager
{

    /**
     * @param UserModel $user
     * 
     * @return array
     */
    public function add(UserModel $user): array
    {

        $password = \password_hash($user->getUserPassword(), PASSWORD_BCRYPT);

        $message = [];
        if (!filter_var($user->getUserEmail(), FILTER_VALIDATE_EMAIL)) {

            $message[] = 'Veuillez utiliser l\'email valide';
        }
        if (!preg_match("/[A-Za-z0-9]+/", $user->getUserName())) {

            $message[] = 'Veuillez utiliser un pseudo composé uniquement des lettres et chiffres';
        }

        $emailQuery = $this->getDb()->prepare('SELECT email FROM user WHERE email = ?');
        $emailQuery->execute(array($user->getUserEmail()));
        $existantEmail = $emailQuery->fetch(\PDO::FETCH_ASSOC);

        if (!empty($existantEmail)) {

            $message[] = 'Cet email est déjà utilisé';
        }

        if (empty($message)) {
            $users = $this->getDb()->prepare('INSERT INTO user (login, password, email, role) VALUES (:login, :password, :email, :role)');

            $users->execute([':login' => $user->getUserName(), ':password' => $password, ':email' => $user->getUserEmail(), ':role' => 0]);
            $message[] = 'Votre compte a été créé avec success';
        }

        return $message;
    }

    /**
     * @param string $password
     * @param string $token
     * 
     * @return string
     */
    public function modifyPassword(string $password, string $token): string
    {
        $password = \password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->getDb()->prepare('UPDATE user SET password = :password WHERE token = :token');
        $statement->execute([':password' => $password, ':token' => $token]);
        $statement = $this->getDb()->prepare('UPDATE user SET token = null WHERE token = :token');
        $statement->execute([':token' => $token]);
        return 'Votre mot de passe a été modifié avec succés';
    }

    /**
     * @param string $email
     * 
     * @return string
     */
    public function getTokenForPasswordReset(string $email): string
    {
        $statement = $this->getDb()->prepare('SELECT email FROM user WHERE email = ?');
        $statement->execute(array($email));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        $token = '';
        if (!empty($result)) {
            $token = bin2hex(random_bytes(50));
        }

        $statement = $this->getDb()->prepare('UPDATE user SET token =:token WHERE email = :email');
        $statement->execute([':token' => $token, ':email' => $email]);

        return $token;
    }

    /**
     * @param int $userId
     * 
     * @return array
     */
    public function getUser(int $userId): array
    {
        $statement = $this->getDb()->prepare('SELECT user_id, login, email, role FROM user WHERE user_id = ?');
        $statement->execute(array($userId));
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * @param string $email
     * 
     * @return array
     */
    public function getCredentials(string $email): array
    {
        $statement = $this->getDb()->prepare('SELECT user_id, password FROM user WHERE email = ?');
        $statement->execute(array($email));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @return array
     */
    public function listUsers(): array
    {
        $statement = $this->getDb()->prepare('SELECT user_id, login, email, role FROM user ORDER BY user_id DESC');
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }


    /**
     * @param string $email
     * @param string $password
     * 
     * @return int
     */
    public function logIn(string $email, string $password): int
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
