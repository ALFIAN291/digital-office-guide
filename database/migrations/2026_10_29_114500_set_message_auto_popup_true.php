<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::table('home_settings')->update(['message_auto_popup' => true]);
        } catch (\Throwable $e) {
            // Ignore if table does not exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

