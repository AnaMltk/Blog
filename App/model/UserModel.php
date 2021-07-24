<?php

namespace App\model;

use App\controller\Hydrator;

class UserModel extends Model
{


  protected $userId;
  protected $userName;
  protected $userEmail;
  protected $userPassword;
  protected $role;
  protected $token;

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
   * @return int
   */
  public function getRole(): int
  {
    return $this->role;
  }

  /**
   * @return string|null
   */
  public function getToken()
  {
    return $this->token;
  }

  /**
   * @param int $userId
   * 
   * @return void
   */
  public function setUserId(int $userId): void
  {
    $this->userId = $userId;
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

  /**
   * @param int $role
   * 
   * @return void
   */
  public function setRole(int $role): void
  {
    $this->role = $role;
  }

  /**
   * @param string|null $token
   * 
   * @return void
   */
  public function setToken(string $token = null): void
  {
    $this->token = $token;
  }
}
