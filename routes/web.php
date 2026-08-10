<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('customers')->name('customers.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{customer}/edit', 'edit')->name('edit');
        Route::put('/{customer}', 'update')->name('update');
        Route::delete('/{customer}', 'destroy')->name('destroy');
        Route::get('/{customer}/measurement/edit', [MeasurementController::class, 'edit'])->name('measurement.edit');
        Route::post('/{customer}/measurement', [MeasurementController::class, 'store'])->name('measurement.store');
        Route::get('/{customer}', 'show')->name('show');
    });

    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/customers-search', 'searchCustomers')->name('customers-search');
        Route::post('/', 'store')->name('store');
        Route::get('/{order}/edit', 'edit')->name('edit');
        Route::put('/{order}', 'update')->name('update');
        Route::put('/{order}/status', 'updateStatus')->name('update-status');
        Route::delete('/{order}', 'destroy')->name('destroy');
    });
});

Route::redirect('/', '/login');
Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout');
