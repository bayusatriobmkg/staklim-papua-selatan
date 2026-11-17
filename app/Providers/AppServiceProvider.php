<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force HTTPS if connection is secure or behind reverse proxy (Cloudflare/Nginx/Ngrok)
        if (
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_HOST']) && (str_contains($_SERVER['HTTP_HOST'], 'ngrok') || str_contains($_SERVER['HTTP_HOST'], 'devbmkg.my.id') || str_contains($_SERVER['HTTP_HOST'], 'bmkg.go.id')))
        ) {
            URL::forceScheme('https');
        }
    }
}

