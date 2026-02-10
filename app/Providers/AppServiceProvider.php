<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Services\PaymentServices;
use App\Services\StripePaymentServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentServices::class,StripePaymentServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware("api")
            ->prefix("api")
            ->group(base_path("routes/api.php"));

        Route::middleware("web")
            ->group(base_path("routes/web.php"));
    }
}