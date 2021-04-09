<?php
require 'model/AppModel.php';
class UserModel extends AppModel
{



 public function add($login, $password, $email, $role)
  {

    $users = $this->db->prepare('INSERT INTO user (login, password, email, role) VALUES (:login, ?, ?, ?)');
    $newUser = $users->execute([':login'=>$login, $password, $email, $role]);
    return $newUser;
  }

  function modifyPassword($password, $userId)
  {
    $statement = $this->db->prepare('UPDATE user SET password = ? WHERE user_id = ?');
    $user = $statement->execute(array($password, $userId));
    return $user;
  }

  function getUser($userId)
  {
    $statement = $this->db->prepare('SELECT login, email, role FROM user WHERE user_id = ?');
    $statement->execute(array($userId));
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  function getCredentials($email)
  {
    $statement = $this->db->prepare('SELECT password FROM user WHERE email = ?');
    $statement->execute(array($email));

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
  }

  function listUsers()
  {
    $statement = $this->db->prepare('SELECT user_id, login, email, role FROM user ORDER BY user_id DESC');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }
}
