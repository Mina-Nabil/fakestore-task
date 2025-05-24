<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AbstractServices\UsersService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $usersService;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->usersService = app(UsersService::class);
    }

    /**
     * Test creating a user with valid credentials
     */
    public function test_creating_a_user_with_valid_credentials(): void
    {
        $this->artisan('app:create-user', [
            'username' => 'testuser',
            'password' => 'testpassword',
        ]);

        $user = $this->usersService->getUser('testuser');

        $this->assertNotNull($user);
        $this->assertEquals('testuser', $user->username);
        $this->assertNotEquals('testpassword', $user->password);
        $this->assertTrue(Hash::check('testpassword', $user->password));
    }

    public function test_creating_a_user_with_invalid_credentials(): void
    {
        $this->assertThrows(function () {
            User::create([
                'username' => 'testuser',
            ]);
        }, Exception::class);
    }
}
