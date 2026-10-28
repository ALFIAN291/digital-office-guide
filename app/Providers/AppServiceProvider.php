<?php

namespace App\Providers;

use App\Models\HomeSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || getenv('VERCEL')) {
            $tempStorage = '/tmp/storage';
            $this->app->useStoragePath($tempStorage);
            $this->app->instance('path.storage', $tempStorage);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('home_settings')) {
                    $view->with('settings', HomeSetting::current());
                }
            } catch (\Throwable $e) {
                // fallback if DB not ready yet
            }
        });
    }
}
