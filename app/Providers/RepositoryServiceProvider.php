<?php

namespace App\Providers;

use App\Repository\Interfaces\CustomerInterface;
use App\Repository\Interfaces\MeasurementInterface;
use App\Repository\Repositories\CustomerRepository;
use App\Repository\Repositories\MeasurementRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(MeasurementInterface::class, MeasurementRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
