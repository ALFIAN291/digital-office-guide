<?php

if (!function_exists('office_image')) {
    /**
     * Safely resolve office image paths, supporting local assets, external URLs, and base64 data URIs.
     */
    function office_image(?string $path, ?string $default = 'images/facilities-office.jpg'): string
    {
        if (empty($path)) {
            return $default ? asset(ltrim($default, '/')) : '';
        }
        if (str_starts_with($path, 'data:') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset(ltrim($path, '/'));
    }
}
