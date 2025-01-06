<?php

namespace InovantiBank\AdvancedQueryFilters\Providers;

use Illuminate\Support\ServiceProvider;
use InovantiBank\AdvancedQueryFilters\Services\FilterService;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/advanced-query-filters.php',
            'advanced-query-filters'
        );

        $this->app->singleton('filterservice', function ($app) {
            return new FilterService(config('advanced-query-filters.supported_filters'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/advanced-query-filters.php' => config_path('advanced-query-filters.php'),
        ], 'config');
    }
}
