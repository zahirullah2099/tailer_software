<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (\Schema::hasTable('settings')) {
                $view->with([
                    'shopName' => Setting::get('shop_name', 'Tailor Shop'),
                    'shopLogo' => Setting::get('shop_logo'),
                ]);
            }
        });
    }
}
