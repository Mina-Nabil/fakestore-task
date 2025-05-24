<?php

namespace App\Providers;

use App\Services\AbstractServices\ProductsService;
use App\Services\AbstractServices\UsersService;
use App\Services\Eloquent\EloquentProductsService;
use App\Services\Eloquent\EloquentUsersService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsersService::class, EloquentUsersService::class);
        $this->app->bind(ProductsService::class, EloquentProductsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
