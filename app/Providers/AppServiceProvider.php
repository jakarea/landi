<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Laravel\Fortify\FortifyServiceProvider::class);
        $this->app->register(\App\Providers\FortifyServiceProvider::class);
        $this->app->singleton('files', function ($app) {
            return new \Illuminate\Filesystem\Filesystem;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default pagination view to Bootstrap 5
        Paginator::defaultView('pagination.bootstrap-5');
        Paginator::defaultSimpleView('pagination.simple-bootstrap-5');
    }
}
