<?php

namespace App\Services\AbstractServices;

use App\Exceptions\ApiCallException;
use App\Exceptions\ProductManagementException;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class ProductsService
{
    const EDITABLE_FIELDS = ['title', 'price', 'description', 'image'];

    /**
     * Import products from the FakeStoreAPI, updates existing products if they already exist and creates new ones if they don't.
     * 
     * @return void
     * @throws ApiCallException - if the API call fails
     */
    abstract public function importProducts(): void;

    /**
     * Get all products
     * 
     * @return Collection - all products
     */
    abstract public function getProducts(): Collection;


    /**
     * Get a product by ID
     * 
     * @param int $id
     * @return Product - the product or null if not found
     */
    abstract public function getProduct($id): ?Product;

    /**
     * Edit a product
     * 
     * @param Product $product
     * @param array $data - [title => string, price => float, description => string, image => string]
     * @return Product
     * @throws ProductManagementException - if invalid field is provided or DB error occurs
     */
    abstract public function editProduct(Product $product, array $data): Product;
    

    /**
     * Get the number of products
     * 
     * @return int
     */
    abstract public function getProductCount(): int;


    protected function fetchAllProducts()
    {       
        Log::info('Importing products from the FakeStoreAPI...');
        $response = Http::get(env('FAKE_STORE_API_URL'));
        Log::info('Response: ' . $response->body());

        if ($response->failed()) {
            $message = json_encode([
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            report(new Exception($message));
            throw new ApiCallException('Failed to import products. Please try again later.');
        }
        $products = $response->json();
        Log::info('Products: ' . json_encode($products));
        return $products;
    }


    protected function fetchProduct($id)
    {
        Log::info('Importing product from the FakeStoreAPI...');
        $response = Http::get(env('FAKE_STORE_API_URL') . '/' . $id);
        Log::info('Response: ' . $response->body());

        if ($response->failed()) {
            $message = json_encode([
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            report(new Exception($message));
            throw new ApiCallException('Failed to import product. Please try again later.');
        }
        $product = $response->json();
        Log::info('Product: ' . json_encode($product));
        return $product;
    }
}
