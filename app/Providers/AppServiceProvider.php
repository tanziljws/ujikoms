<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS - selalu aktif untuk memastikan semua URL HTTPS
        // Railway menggunakan reverse proxy, jadi perlu force HTTPS
        URL::forceScheme('https');
    }
}
