<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Microsoft\Provider as MicrosoftProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can add bindings or configurations here if necessary.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Microsoft driver with Socialite
        Socialite::extend('microsoft', function ($app) {
            $config = $app['config']['services.microsoft'];

            return Socialite::buildProvider(MicrosoftProvider::class, $config);
        });
    }
}