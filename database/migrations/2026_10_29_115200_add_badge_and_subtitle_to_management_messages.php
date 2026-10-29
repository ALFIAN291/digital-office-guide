<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('management_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('management_messages', 'badge_label')) {
                $table->string('badge_label', 100)->default('Official Announcement')->nullable();
            }
            if (!Schema::hasColumn('management_messages', 'subtitle')) {
                $table->string('subtitle', 150)->default('Karawang Office 2026')->nullable();
            }
        });

        // Update existing row
        try {
            DB::table('management_messages')->update([
                'badge_label' => 'Official Announcement',
                'subtitle' => 'Karawang Office 2026',
            ]);
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('management_messages', function (Blueprint $table) {
            if (Schema::hasColumn('management_messages', 'badge_label')) {
                $table->dropColumn('badge_label');
            }
            if (Schema::hasColumn('management_messages', 'subtitle')) {
                $table->dropColumn('subtitle');
            }
        });
    }
};

