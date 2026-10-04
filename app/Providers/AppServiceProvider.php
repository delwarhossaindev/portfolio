<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // utf8mb4 indexes on older MySQL/MariaDB (common on shared hosting) cap at 767 bytes.
        Schema::defaultStringLength(191);

        // Force HTTPS scheme on generated URLs when running in production.
        // Combined with TrustProxies (in bootstrap/app.php) this works behind load balancers.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
