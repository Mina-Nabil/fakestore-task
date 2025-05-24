<?php

namespace App\Services\Eloquent;

use App\Exceptions\ApiCallException;
use App\Exceptions\ProductManagementException;
use App\Models\Product;
use App\Services\AbstractServices\ProductsService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EloquentProductsService extends ProductsService
{

    const EDITABLE_FIELDS = ['title', 'price', 'description', 'image'];

    /**
     * Import products from the FakeStoreAPI, updates existing products if they already exist and creates new ones if they don't.
     * 
     * @return void
     * @throws ApiCallException - if the API call fails
     */
    public function importProducts(): void
    {
        $productsCount = $this->getProductCount();

        if ($productsCount == 0) {
            if (App::hasDebugModeEnabled()) {
                Log::info('No products found, fetching all products from the FakeStoreAPI...');
            }
            $products = $this->fetchAllProducts();
        } else {
            if (App::hasDebugModeEnabled()) {
                Log::info('Products found, fetching updated products from the FakeStoreAPI...');
            }
            $updatedProducts = Product::isUpdated()->get()->pluck('id')->toArray();
            foreach ($updatedProducts as $productId) {
                $products[] = $this->fetchProduct($productId);
            }
        }

        if (App::hasDebugModeEnabled()) {
            Log::info('Products: ' . json_encode($products));
        }

        try {
            DB::transaction(function () use ($products) {
                foreach ($products as $product) {
                    Product::updateOrCreate([
                        'id' => $product['id'],
                    ], [
                        'title' => $product['title'],
                        'price' => $product['price'],
                        'description' => $product['description'],
                        'category' => $product['category'],
                        'image' => $product['image'],
                        'is_updated' => false,
                    ]);
                }
            });
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            throw new ProductManagementException('Failed to import products. Please try again later.');
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
            $data['is_updated'] = true;
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
