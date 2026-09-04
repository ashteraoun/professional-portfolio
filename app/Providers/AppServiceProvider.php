<?php

namespace App\Providers;

use App\Services\SiteSettingsService;
use App\View\Composers\SiteComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteSettingsService::class);
    }

    public function boot(): void
    {
        View::composer(['layouts.portfolio', 'pages.*', 'components.*'], SiteComposer::class);

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by($request->ip());
        });
    }
}
