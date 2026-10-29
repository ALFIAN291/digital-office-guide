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

        // Auto-fix Neon PostgreSQL SNI endpoint requirement
        $dbConfig = config('database.connections.pgsql', []);
        $parsed = (new \Illuminate\Database\ConfigurationUrlParser())->parseConfiguration($dbConfig);
        $host = $parsed['host'] ?? '';
        if ($host && str_contains($host, 'neon.tech')) {
            $endpointId = preg_replace('/-pooler$/', '', explode('.', $host)[0]);
            if (str_starts_with($endpointId, 'ep-')) {
                $user = $parsed['username'] ?? '';
                if ($user && !str_contains($user, '$')) {
                    $parsed['username'] = "{$user}\${$endpointId}";
                }
            }
        }
        $parsed['url'] = null;
        $parsed['options'] = [];
        config(['database.connections.pgsql' => $parsed]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || getenv('VERCEL')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

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
