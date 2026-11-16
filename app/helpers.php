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

if (!function_exists('office_media')) {
    /**
     * Resolve an image path on a model record, serving database base64 blobs
     * via the cacheable /media endpoint instead of inlining megabytes of data URIs into HTML.
     */
    function office_media(?object $record, string $column = 'image_path', ?string $default = 'images/facilities-office.jpg'): string
    {
        if (!$record) {
            return office_image(null, $default);
        }

        $value = $record->{$column} ?? null;
        if (empty($value)) {
            return office_image(null, $default);
        }

        if (is_string($value) && str_starts_with($value, 'data:')) {
            $map = [
                \App\Models\HomeSetting::class => 'home',
                \App\Models\ManagementMessage::class => 'message',
                \App\Models\Facility::class => 'facility',
                \App\Models\DosAndDont::class => 'rule',
                \App\Models\DeskCard::class => 'desk',
                \App\Models\OfficeZone::class => 'zone',
            ];

            $class = get_class($record);
            $type = $map[$class] ?? null;
            $id = $record->id ?? null;

            if ($type && !empty($id)) {
                return url('/media/' . $type . '/' . $id . '/' . $column . '?v=' . substr(md5($value), 0, 10));
            }
        }

        return office_image($value, $default);
    }
}

if (!function_exists('office_compress_raster_image')) {
    /**
     * Downscale and re-encode an oversized raster image buffer via PHP GD (when available).
     *
     * @return array{0: string, 1: string} [binary, mimeType]
     */
    function office_compress_raster_image(string $binary, string $mime, int $maxDim = 1400, int $quality = 82): array
    {
        if ($binary === '' || !function_exists('imagecreatefromstring')) {
            return [$binary, $mime];
        }

        try {
            $src = @imagecreatefromstring($binary);
            if (!$src) {
                return [$binary, $mime];
            }

            $w = imagesx($src);
            $h = imagesy($src);
            if ($w <= 0 || $h <= 0) {
                return [$binary, $mime];
            }

            $nw = $w;
            $nh = $h;
            if (max($w, $h) > $maxDim) {
                $scale = $maxDim / max($w, $h);
                $nw = max(1, (int) round($w * $scale));
                $nh = max(1, (int) round($h * $scale));
            }

            $bestBinary = $binary;
            $bestMime = $mime;

            if (function_exists('imagewebp')) {
                $canvas = imagecreatetruecolor($nw, $nh);
                if ($canvas) {
                    imagealphablending($canvas, false);
                    imagesavealpha($canvas, true);
                    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
                    imagefilledrectangle($canvas, 0, 0, $nw, $nh, $transparent);
                    imagecopyresampled($canvas, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    ob_start();
                    imagewebp($canvas, null, $quality);
                    $candidate = ob_get_clean();
                    if (is_string($candidate) && $candidate !== '' && strlen($candidate) < strlen($bestBinary)) {
                        $bestBinary = $candidate;
                        $bestMime = 'image/webp';
                    }
                }
            }

            if ($bestBinary === $binary || strlen($bestBinary) > 350000) {
                $canvas = imagecreatetruecolor($nw, $nh);
                if ($canvas) {
                    imagealphablending($canvas, true);
                    $white = imagecolorallocate($canvas, 255, 255, 255);
                    imagefilledrectangle($canvas, 0, 0, $nw, $nh, $white);
                    imagecopyresampled($canvas, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    ob_start();
                    imagejpeg($canvas, null, $quality);
                    $candidate = ob_get_clean();
                    if (is_string($candidate) && $candidate !== '' && strlen($candidate) < strlen($bestBinary)) {
                        $bestBinary = $candidate;
                        $bestMime = 'image/jpeg';
                    }
                }
            }

            return [$bestBinary, $bestMime];
        } catch (\Throwable $e) {
            return [$binary, $mime];
        }
    }
}

if (!function_exists('office_compress_data_uri')) {
    /**
     * Compress an oversized data:image/...;base64 URI in place if GD can shrink it.
     */
    function office_compress_data_uri(string $dataUri, int $minBytesToCompress = 450000, int $maxDim = 1400, int $quality = 82): string
    {
        if (strlen($dataUri) <= $minBytesToCompress || !function_exists('imagecreatefromstring')) {
            return $dataUri;
        }

        if (!preg_match('/^data:(image\/[a-zA-Z0-9.+-]+);base64,(.*)$/s', $dataUri, $matches)) {
            return $dataUri;
        }

        $mime = strtolower($matches[1]);
        $binary = base64_decode(preg_replace('/\s+/', '', $matches[2]), true);
        if ($binary === false || $binary === '') {
            return $dataUri;
        }

        [$compressed, $newMime] = office_compress_raster_image($binary, $mime, $maxDim, $quality);
        if (strlen($compressed) >= strlen($binary)) {
            return $dataUri;
        }

        return "data:{$newMime};base64," . base64_encode($compressed);
    }
}

