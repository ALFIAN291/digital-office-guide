<?php

/**
 * Vercel Serverless Function Entry Point for Laravel
 */

// Prepare writable storage & view paths in /tmp (since Vercel root is read-only)
$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
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

