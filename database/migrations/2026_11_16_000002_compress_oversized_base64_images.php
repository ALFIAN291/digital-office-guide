<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Compress oversized base64 data:image/* blobs already stored in database columns
     * so response payloads stay well under serverless limits and save DB bandwidth.
     */
    public function up(): void
    {
        if (!function_exists('imagecreatefromstring') || !function_exists('office_compress_data_uri')) {
            return;
        }

        $targets = [
            'home_settings' => ['hero_image', 'card_office_image', 'card_facilities_image', 'card_map_image', 'card_rules_image'],
            'management_messages' => ['image_path'],
            'facilities' => ['image_path'],
            'dos_and_donts' => ['image_path'],
            'desk_cards' => ['image_path'],
            'office_zones' => ['image_path'],
        ];

        foreach ($targets as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            $existingColumns = array_values(array_filter(
                $columns,
                fn (string $col) => Schema::hasColumn($table, $col)
            ));

            if (empty($existingColumns)) {
                continue;
            }

            try {
                $rows = DB::table($table)->select(array_merge(['id'], $existingColumns))->get();
                foreach ($rows as $row) {
                    $updates = [];
                    foreach ($existingColumns as $col) {
                        $val = $row->{$col} ?? null;
                        if (is_string($val) && str_starts_with($val, 'data:image/') && strlen($val) > 450000) {
                            $compressed = office_compress_data_uri($val, 450000, 1400, 82);
                            if (strlen($compressed) < strlen($val)) {
                                $updates[$col] = $compressed;
                            }
                        }
                    }

                    if (!empty($updates)) {
                        DB::table($table)->where('id', $row->id)->update($updates);
                    }
                }
            } catch (\Throwable $e) {
                // Skip safely so migrations never fail due to an unreadable custom blob.
            }
        }
    }

    public function down(): void
    {
        // Compressing oversized raster images is intentionally one-way and lossless-to-user.
    }
};
