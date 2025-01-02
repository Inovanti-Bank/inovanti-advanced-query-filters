<?php

namespace InovantiBank\AdvancedQueryFilters\Providers;

use Illuminate\Support\ServiceProvider;
use InovantiBank\AdvancedQueryFilters\Services\FilterService;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('filter-service', function ($app) {
            return new FilterService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/advanced-query-filters.php' => config_path('advanced-query-filters.php'),
        ], 'config');
    }
}
