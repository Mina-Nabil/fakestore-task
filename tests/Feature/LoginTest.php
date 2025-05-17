<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    /**
     * Test login with valid credentials
     */
    public function test_login_with_valid_credentials(): void
    {
        $this->artisan('app:create-user', [
            'username' => 'testuser',
            'password' => 'testpassword',
        ]);

        $response = $this->post('/api/login', [
            'username' => 'testuser',
            'password' => 'testpassword',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
        ]);
    }

    public function test_login_with_invalid_credentials(): void
    {
        $this->artisan('app:create-user', [
            'username' => 'testuser',
            'password' => 'testpassword',
        ]);

        
        $response = $this->post('/api/login', [
            'username' => 'testuser',
            'password' => 'invalidpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message',
        ]);


        $response = $this->post('/api/login', [
            'username' => 'invaliduser',
            'password' => 'testpassword',
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
        ]);
    }
}
