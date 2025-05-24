<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Services\AbstractServices\ProductsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    protected $productsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->productsService = app(ProductsService::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_product(): void
    {
        $this->productsService->importProducts();

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
        $this->productsService->importProducts();

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
        $this->productsService->importProducts();

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

    public function test_sync_products_after_update(): void
    {
        //importing products
        $this->productsService->importProducts();

        //saving old product values
        $product = Product::first();
        $oldTitle = $product->title;
        $oldPrice = $product->price;
        $oldDescription = $product->description;
        $oldImage = $product->image;

        //updating product 1
        $this->productsService->editProduct($product, [
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
        ]);

        //asserting that the product was updated
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Title',
            'price' => 100,
            'description' => 'Updated Description',
            'image' => 'https://example.com/updated-image.jpg',
        ]);

        //importing products again to test if the product is synced
        $this->productsService->importProducts();

        //asserting that the product was synced
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => $oldTitle,
            'price' => $oldPrice,
            'description' => $oldDescription,
            'image' => $oldImage,
        ]);
    }
}
