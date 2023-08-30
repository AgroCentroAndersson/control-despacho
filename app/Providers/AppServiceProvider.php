<?php

namespace App\Providers;

use App\Models\Grocer;
use App\Observers\GrocerObserver;
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
        Grocer::observe(GrocerObserver::class);
    }
}
