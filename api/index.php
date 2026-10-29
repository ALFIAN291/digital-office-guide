<?php

/**
 * Vercel Serverless Function Entry Point for Laravel
 */

putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on')) {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Auto-detect Postgres connection string from Vercel / Neon integrations
$urlKeys = [
    'POSTGRES_URL',
    'POSTGRES_URL_NON_POOLING',
    'POSTGRES_PRISMA_URL',
    'DATABASE_URL',
    'NEON_DATABASE_URL',
    'DB_URL',
];

foreach ($urlKeys as $key) {
    $val = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
    if (!empty($val)) {
        // Auto-fix Neon SNI endpoint requirement
        $parsed = parse_url($val);
        if (!empty($parsed['host'])) {
            $endpointId = preg_replace('/-pooler$/', '', explode('.', $parsed['host'])[0]);
            if (str_starts_with($endpointId, 'ep-') && !empty($parsed['user']) && !str_contains($parsed['user'], '$')) {
                $newUser = $parsed['user'] . '$' . $endpointId;
                $passPart = isset($parsed['pass']) ? ':' . $parsed['pass'] : '';
                $portPart = isset($parsed['port']) ? ':' . $parsed['port'] : '';
                $pathPart = $parsed['path'] ?? '/neondb';
                $queryPart = isset($parsed['query']) ? '?' . $parsed['query'] : '?sslmode=require';
                $val = "postgres://{$newUser}{$passPart}@{$parsed['host']}{$portPart}{$pathPart}{$queryPart}";
                putenv("DB_USERNAME={$newUser}");
                $_ENV['DB_USERNAME'] = $newUser;
                $_SERVER['DB_USERNAME'] = $newUser;
            }
        }

        putenv("DB_URL={$val}");
        $_ENV['DB_URL'] = $val;
        $_SERVER['DB_URL'] = $val;
        break;
    }
}

// Auto-detect individual Postgres credentials
$hostKeys = ['POSTGRES_HOST', 'PGHOST', 'DB_HOST'];
$foundHost = null;
foreach ($hostKeys as $key) {
    $val = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
    if (!empty($val)) {
        $foundHost = $val;
        putenv("DB_HOST={$val}");
        $_ENV['DB_HOST'] = $val;
        $_SERVER['DB_HOST'] = $val;
        break;
    }
}

$userKeys = ['POSTGRES_USER', 'PGUSER', 'DB_USERNAME'];
foreach ($userKeys as $key) {
    $val = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
    if (!empty($val)) {
        if ($foundHost && str_contains($foundHost, 'neon.tech')) {
            $endpointId = preg_replace('/-pooler$/', '', explode('.', $foundHost)[0]);
            if (str_starts_with($endpointId, 'ep-') && !str_contains($val, '$')) {
                $val = "{$val}\${$endpointId}";
            }
        }
        putenv("DB_USERNAME={$val}");
        $_ENV['DB_USERNAME'] = $val;
        $_SERVER['DB_USERNAME'] = $val;
        break;
    }
}

$passKeys = ['POSTGRES_PASSWORD', 'PGPASSWORD', 'DB_PASSWORD'];
foreach ($passKeys as $key) {
    $val = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
    if (!empty($val)) {
        putenv("DB_PASSWORD={$val}");
        $_ENV['DB_PASSWORD'] = $val;
        $_SERVER['DB_PASSWORD'] = $val;
        break;
    }
}

$dbKeys = ['POSTGRES_DATABASE', 'PGDATABASE', 'DB_DATABASE'];
foreach ($dbKeys as $key) {
    $val = $_SERVER[$key] ?? $_ENV[$key] ?? getenv($key);
    if (!empty($val)) {
        putenv("DB_DATABASE={$val}");
        $_ENV['DB_DATABASE'] = $val;
        $_SERVER['DB_DATABASE'] = $val;
        break;
    }
}

// Prepare writable storage & view paths in /tmp (since Vercel root is read-only)
$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/views',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Delegate request to Laravel's standard front controller
require __DIR__ . '/../public/index.php';
