<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/products/{product}', [ProductController::class, 'update']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
