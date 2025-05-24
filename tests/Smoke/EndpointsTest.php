<?php

namespace Tests\Smoke;

use App\Models\Product;
use App\Models\User;
use App\Services\AbstractServices\ProductsService;
use App\Services\AbstractServices\UsersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class EndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected $productsService;
    protected $usersService;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->productsService = app(ProductsService::class);
        $this->usersService = app(UsersService::class);
    }

    /**
     * A basic test example.
     */
    public function test_login_endpoint(): void
    {
        $response = $this->post('/api/login', [
            'username' => 'test',
            'password' => 'test',
        ]);

        $response->assertStatus(404);
    }

    public function test_products_endpoint(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_update_product_endpoint(): void
    {
        Product::create([
            'title' => 'test',
            'price' => 10,
            'category' => 'test',
            'description' => 'test',
            'image' => 'test',
        ]);

        $response = $this
        ->actingAs(User::factory()->create())
        ->put('/api/products/1', [
            'title' => 'test',
            'price' => 10,
            'description' => 'test',
            'image' => 'test',
        ]);

        $response->assertStatus(200);
    }
}
