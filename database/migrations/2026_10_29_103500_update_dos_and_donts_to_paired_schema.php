<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dos_and_donts', function (Blueprint $table) {
            if (!Schema::hasColumn('dos_and_donts', 'image_path')) {
                $table->text('image_path')->nullable();
            }
            if (!Schema::hasColumn('dos_and_donts', 'do_text')) {
                $table->text('do_text')->nullable();
            }
            if (!Schema::hasColumn('dos_and_donts', 'do_sub')) {
                $table->text('do_sub')->nullable();
            }
            if (!Schema::hasColumn('dos_and_donts', 'dont_text')) {
                $table->text('dont_text')->nullable();
            }
            if (!Schema::hasColumn('dos_and_donts', 'dont_sub')) {
                $table->text('dont_sub')->nullable();
            }
            if (!Schema::hasColumn('dos_and_donts', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        // Make legacy columns nullable for PostgreSQL / MySQL / SQLite compatibility
        try {
            DB::statement('ALTER TABLE dos_and_donts ALTER COLUMN type DROP NOT NULL');
            DB::statement('ALTER TABLE dos_and_donts ALTER COLUMN title DROP NOT NULL');
            DB::statement('ALTER TABLE dos_and_donts ALTER COLUMN description DROP NOT NULL');
        } catch (\Throwable $e) {
            // Silently continue if SQLite or already nullable
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dos_and_donts', function (Blueprint $table) {
            $columns = ['image_path', 'do_text', 'do_sub', 'dont_text', 'dont_sub', 'is_active'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('dos_and_donts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

