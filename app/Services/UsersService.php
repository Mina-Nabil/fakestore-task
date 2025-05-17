<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserManagementException;

class UsersService
{

    const USER_NOT_FOUND_ERROR_CODE = 100;
    const INVALID_PASSWORD_ERROR_CODE = 101;

  /**
   * Login a user
   * 
   * @param string $username
   * @param string $password
   * @return string
   */
  public function login(string $username, string $password): string
  {
    /** @var User $user */
    $user = $this->getUser($username);

    if (!$user) {
      throw new UserManagementException('User not found', self::USER_NOT_FOUND_ERROR_CODE);
    }

    if (!Hash::check($password, $user->password)) {
      throw new UserManagementException('Invalid credentials', self::INVALID_PASSWORD_ERROR_CODE);
    }
    return $user->createToken('auth_token')->plainTextToken;
  }

  /**
   * Get a user by username
   * 
   * @param string $username
   * @return User
   */
  public function getUser(string $username): ?User
  {
    return User::where('username', $username)->first();
  }

  /**
   * Create a new user
   * 
   * @param string $username
   * @param string $password
   * @return User
   */
  public function createUser(string $username, string $password): User
  {
    return User::create([
      'username' => $username,
      'password' => Hash::make($password),
    ]);
  }
}