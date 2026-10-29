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
                $directHost = str_replace('-pooler.', '.', $host);
                $parsed['host'] = "{$directHost};options='endpoint={$endpointId}'";
                // Ensure username does not contain extra $endpointId
                if (!empty($parsed['username']) && str_contains($parsed['username'], '$')) {
                    $parsed['username'] = explode('$', $parsed['username'])[0];
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
                static $cachedSettings = null;
                if ($cachedSettings === null && Schema::hasTable('home_settings')) {
                    $cachedSettings = HomeSetting::current();
                }
                if ($cachedSettings) {
                    $view->with('settings', $cachedSettings);
                }
            } catch (\Throwable $e) {
                // fallback if DB not ready yet
            }
        });
    }
}
