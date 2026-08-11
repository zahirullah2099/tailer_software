<?php

namespace App\Providers;

use App\Repository\Interfaces\CustomerInterface;
use App\Repository\Interfaces\MeasurementInterface;
use App\Repository\Interfaces\OrderInterface;
use App\Repository\Interfaces\PaymentInterface;
use App\Repository\Repositories\CustomerRepository;
use App\Repository\Repositories\MeasurementRepository;
use App\Repository\Repositories\OrderRepository;
use App\Repository\Repositories\PaymentRepository;
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
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
