<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Implementations\ProductRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Implementations\CustomerRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Implementations\OrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind Interfaces to Implementations
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}