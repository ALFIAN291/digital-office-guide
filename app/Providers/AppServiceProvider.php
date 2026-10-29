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
        $host = $dbConfig['host'] ?? '';
        if ($host && str_contains($host, 'neon.tech')) {
            $endpointId = preg_replace('/-pooler$/', '', explode('.', $host)[0]);
            if (str_starts_with($endpointId, 'ep-')) {
                $user = $dbConfig['username'] ?? '';
                if ($user && !str_contains($user, '$')) {
                    config(['database.connections.pgsql.username' => "{$user}\${$endpointId}"]);
                }

                $url = $dbConfig['url'] ?? null;
                if ($url && !str_contains($url, '$' . $endpointId)) {
                    $parsed = parse_url($url);
                    if (!empty($parsed['user']) && !str_contains($parsed['user'], '$')) {
                        $newUser = $parsed['user'] . '$' . $endpointId;
                        $passPart = isset($parsed['pass']) ? ':' . $parsed['pass'] : '';
                        $portPart = isset($parsed['port']) ? ':' . $parsed['port'] : '';
                        $pathPart = $parsed['path'] ?? '/neondb';
                        $queryPart = isset($parsed['query']) ? '?' . $parsed['query'] : '?sslmode=require';
                        if (!str_contains($queryPart, 'options=')) {
                            $queryPart .= '&options=endpoint%3D' . $endpointId;
                        }
                        $newUrl = "postgres://{$newUser}{$passPart}@{$parsed['host']}{$portPart}{$pathPart}{$queryPart}";
                        config([
                            'database.connections.pgsql.url' => $newUrl,
                            'database.connections.pgsql.username' => $newUser,
                        ]);
                    }
                }
            }
        }
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
