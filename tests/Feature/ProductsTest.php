<?php

namespace Tests\Feature;

use App\Services\AbstractServices\ProductsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
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
    public function test_sync_products(): void
    {
        $this->assertEquals(0, $this->productsService->getProductCount());
        $this->artisan('app:sync-products');
        $this->assertNotEquals(0, $this->productsService->getProductCount());

        $products = $this->productsService->getProducts(); 
        $this->assertEquals($products->count(), $this->productsService->getProductCount());

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
        $this->productsService->importProducts();
        $product = $this->productsService->getProduct(1); 
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
