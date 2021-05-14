<?php

namespace App\model;

use App\controller\Hydrator;

class UserModel extends Model
{


  protected $userId;
  protected $userName;
  protected $userEmail;
  protected $userPassword;
  protected const ROLE = 1;

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
