<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductManagementException;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\AbstractServices\ProductsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private ProductsService $productsService;

    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    public function index()
    {
        return ProductResource::collection($this->productsService->getProducts());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        Log::info('Updating product', ['product' => $product, 'request' => $request->all()]);
        try {
            $updatedProduct = $this->productsService->editProduct($product, $request->all());
        } catch (ProductManagementException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Internal server error. Please try again later.'], 500);
        }
        return new ProductResource($updatedProduct);
    }
}
