<?php

namespace App\model;


class UserModel
{

  private $userId;
  private $userName;
  private $userEmail;
  private $userPassword;
  private const ROLE = 1;

  /*public function hydrate($login, $email, $password)
    {
        $this->setUserName($login);
        $this->setUserEmail($email);
        $this->setUserPassword($password);
        
    }*/

  public function getUserId()
  {
    return $this->userId;
  }

  public function getUserName()
  {
    return $this->userName;
  }

  public function getUserEmail()
  {
    return $this->userEmail;
  }

  public function getUserPassword()
  {
    return $this->userPassword;
  }

  public function setUserName($userName)
  {

    $this->userName = $userName;
  }
  public function setUserEmail($userEmail)
  {

    $this->userEmail = $userEmail;
  }
  public function setUserPassword($userPassword)
  {
    $this->userPassword = $userPassword;
  }
}
