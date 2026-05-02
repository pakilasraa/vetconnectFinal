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
        if (app()->runningInConsole()) {
            return;
        }

        $host = request()->getHost();
        if (str_contains($host, 'ngrok-free.dev')) {
            URL::forceRootUrl('https://' . $host);
            URL::forceScheme('https');
        }
    }
}
