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
        view()->composer('*', function ($view) {
            $loggedInArtist = auth()->user() ? auth()->user()->artist : null;
            $view->with('loggedInArtist', $loggedInArtist);
        });
    }
}
