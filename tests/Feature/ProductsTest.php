<?php

namespace Tests\Feature;

use App\Services\ProductsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
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
    public function test_sync_products(): void
    {
        $productService = new ProductsService();
        $this->assertEquals(0, $productService->getProductCount());
        $this->artisan('app:sync-products');
        $this->assertNotEquals(0, $productService->getProductCount());

        $products = $productService->getProducts(); 
        $this->assertEquals($products->count(), $productService->getProductCount());

        $product = $products->first(); 
        $this->assertArrayHasKey('id', $product);
        $this->assertArrayHasKey('title', $product);
        $this->assertArrayHasKey('price', $product);
        $this->assertIsNumeric($product['price']);
        $this->assertArrayHasKey('description', $product);
        $this->assertArrayHasKey('category', $product);
        $this->assertArrayHasKey('image', $product);
        $this->assertNotFalse(filter_var($product['image'], FILTER_VALIDATE_URL));

    }

    public function test_product_attributes(): void 
    {
        $productService = new ProductsService();
        $productService->importProducts();
        $product = $productService->getProduct(1); 
        $this->assertNotNull($product);
        $this->assertArrayHasKey('id', $product);
        $this->assertArrayHasKey('title', $product);
        $this->assertArrayHasKey('price', $product);
        $this->assertIsNumeric($product['price']);
        $this->assertArrayHasKey('description', $product);
        $this->assertArrayHasKey('category', $product);
        $this->assertArrayHasKey('image', $product);
        $this->assertNotFalse(filter_var($product['image'], FILTER_VALIDATE_URL));
    }
}
