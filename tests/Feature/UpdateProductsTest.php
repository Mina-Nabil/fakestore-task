<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ProductsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    /**
     * A basic feature test example.
     */
    public function test_update_product(): void
    {
        $productService = new ProductsService();
        $productService->importProducts();

        $response = $this->actingAs(User::factory()->create())->putJson('/api/products/1', [
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
        ]);
    }

    public function test_update_product_with_uneditable_field(): void
    {
        $productService = new ProductsService();
        $productService->importProducts();

        $response = $this->actingAs(User::factory()->create())->putJson('/api/products/1', [
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
            'category' => 'Updated Category',
        ]);

        $response->assertStatus(401);
    }

    public function test_update_product_with_invalid_field(): void
    {
        $productService = new ProductsService();
        $productService->importProducts();

        $response = $this->actingAs(User::factory()->create())->putJson('/api/products/1', [
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
            'invalid_field' => 'Invalid Field',
        ]);

        $response->assertStatus(401);
    }

    public function test_update_product_with_invalid_product_id(): void
    {
        $response = $this->actingAs(User::factory()->create())->putJson('/api/products/-1', [
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
        ]);

        $response->assertStatus(404);
    }
}
