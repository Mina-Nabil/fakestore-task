<?php

namespace App\Services;

use App\Exceptions\ApiCallException;
use App\Exceptions\ProductManagementException;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductsService
{

    const API_URL = 'https://fakestoreapi.com/products';
    const EDITABLE_FIELDS = ['title', 'price', 'description', 'image'];

    /**
     * Import products from the FakeStoreAPI, updates existing products if they already exist and creates new ones if they don't.
     * 
     * @return void
     * @throws ApiCallException - if the API call fails
     */
    public function importProducts(): void
    {
        Log::info('Importing products from the FakeStoreAPI...');
        $response = Http::get(self::API_URL);
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

        foreach ($products as $product) {
            Product::firstOrCreate([
                'id' => $product['id'],
            ], [
                'title' => $product['title'],
                'price' => $product['price'],
                'description' => $product['description'],
                'category' => $product['category'],
                'image' => $product['image'],
            ]);
        }
    }

    /**
     * Get all products
     * 
     * @return Collection - all products
     */
    public function getProducts(): Collection
    {
        return Product::all();
    }
    

    /**
     * Get a product by ID
     * 
     * @param int $id
     * @return Product - the product or null if not found
     */
    public function getProduct($id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Edit a product
     * 
     * @param Product $product
     * @param array $data - [title => string, price => float, description => string, image => string]
     * @return Product
     * @throws ProductManagementException - if invalid field is provided or DB error occurs
     */
    public function editProduct(Product $product, array $data): Product
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, self::EDITABLE_FIELDS)) {
                throw new ProductManagementException('Invalid field: ' . $key, 401);
            }
        }
        try {
            $product->update($data);
            return $product;
        } catch (Exception $e) {
            report($e);
            throw new ProductManagementException('Failed to update product. Please try again later.', 500);
        }
    }

    /**
     * Get the number of products
     * 
     * @return int
     */
    public function getProductCount(): int
    {
        return Product::count();
    }
}
