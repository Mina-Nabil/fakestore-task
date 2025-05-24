<?php

namespace App\Http\Controllers;

use App\Exceptions\UserManagementException;
use App\Http\Requests\LoginRequest;
use App\Services\AbstractServices\UsersService;
use Exception;

class UserController extends Controller
{

    private UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        try {
            $token = $this->usersService->login($credentials['username'], $credentials['password']);
            return response()->json([
                'token' => $token,
            ], 200);
        } catch (UserManagementException $e) {
            if ($e->getCode() === UsersService::USER_NOT_FOUND_ERROR_CODE) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            if ($e->getCode() === UsersService::INVALID_PASSWORD_ERROR_CODE) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
            return response()->json([
                'message' => 'Internal server error. Please try again later.',
            ], 500);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Internal server error. Please try again later.',
            ], 500);
        }
    }
}
