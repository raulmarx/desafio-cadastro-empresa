<?php

namespace App\Providers;

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
        $this->app->bind(
            \App\Repositories\ClientEnterpriseRepositoryInterface::class,
            \App\Repositories\ClientEnterpriseEloquentRepository::class
        );

        $this->app->bind(
            \App\Repositories\BillingInfoClientEnterpriseRepositoryInterface::class,
            \App\Repositories\BillingInfoClientEnterpriseEloquentRepository::class
        );      
    }
}
