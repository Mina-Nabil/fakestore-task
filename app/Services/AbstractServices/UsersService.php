<?php 

namespace App\Services\AbstractServices;

use App\Models\User;


abstract class UsersService
{

    const USER_NOT_FOUND_ERROR_CODE = 100;
    const INVALID_PASSWORD_ERROR_CODE = 101;
    const USER_CREATION_ERROR_CODE = 102;
  /**
   * Login a user
   * 
   * @param string $username
   * @param string $password
   * @return string
   */
  abstract public function login(string $username, string $password): string;

  /**
   * Get a user by username
   * 
   * @param string $username
   * @return User
   */
  abstract public function getUser(string $username): ?User;



  /**
   * Get a user by username
   * 
   * @param string $username
   * @return User
   */
  abstract public function createUser(string $username, string $password): User;

}