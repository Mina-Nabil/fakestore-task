<?php 

namespace App\Services\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserManagementException;
use App\Services\AbstractServices\UsersService;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class EloquentUsersService extends UsersService
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
  public function login(string $username, string $password): string
  {
    if (App::hasDebugModeEnabled()) {
      Log::info('Logging in user: ' . $username);
    }

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
    if (App::hasDebugModeEnabled()) {
      Log::info('Getting user: ' . $username);
    }
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

    if (App::hasDebugModeEnabled()) {
      Log::info('Creating user: ' . $username);
    }
    
    if(User::where('username', $username)->exists()){
      throw new UserManagementException('User already exists', self::USER_CREATION_ERROR_CODE);
    }
    
    try{
      return User::create([
        'username' => $username,
        'password' => Hash::make($password),
      ]);
    } catch (Exception $e) {
      report($e);
      throw new UserManagementException('Failed to create user', self::USER_CREATION_ERROR_CODE);
    }
  }
}