<?php

namespace App\model;

use App\controller\Hydrator;

class UserModel extends Model
{


  protected $userId;
  protected $userName;
  protected $userEmail;
  protected $userPassword;
  

  /**
   * @return int
   */
  public function getUserId(): int
  {
    return $this->userId;
  }

  /**
   * @return string
   */
  public function getUserName(): string
  {
    return $this->userName;
  }

  /**
   * @return string
   */
  public function getUserEmail(): string
  {
    return $this->userEmail;
  }

  /**
   * @return string
   */
  public function getUserPassword(): string
  {
    return $this->userPassword;
  }

  /**
   * @param string $userName
   * 
   * @return void
   */
  public function setUserName(string $userName): void
  {

    $this->userName = $userName;
  }

  /**
   * @param string $userEmail
   * 
   * @return void
   */
  public function setUserEmail(string $userEmail): void
  {

    $this->userEmail = $userEmail;
  }
  
  /**
   * @param string $userPassword
   * 
   * @return void
   */
  public function setUserPassword(string $userPassword): void
  {
    $this->userPassword = $userPassword;
  }
}
