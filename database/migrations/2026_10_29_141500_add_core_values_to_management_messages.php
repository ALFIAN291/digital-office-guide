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
            if (!Schema::hasColumn('management_messages', 'show_core_values')) {
                $table->boolean('show_core_values')->default(false);
            }
            if (!Schema::hasColumn('management_messages', 'val_1_title')) {
                $table->string('val_1_title')->default('Safety First')->nullable();
                $table->string('val_1_desc')->default('Prioritas keselamatan tanpa kompromi.')->nullable();
                $table->string('val_2_title')->default('Kolaboratif')->nullable();
                $table->string('val_2_desc')->default('Ruang terbuka sinergi tim.')->nullable();
                $table->string('val_3_title')->default('5S & Green')->nullable();
                $table->string('val_3_desc')->default('Disiplin 5S & ramah lingkungan.')->nullable();
            }
        });

        try {
            DB::table('management_messages')->update([
                'show_core_values' => false,
                'val_1_title' => 'Safety First',
                'val_1_desc' => 'Prioritas keselamatan tanpa kompromi.',
                'val_2_title' => 'Kolaboratif',
                'val_2_desc' => 'Ruang terbuka sinergi tim.',
                'val_3_title' => '5S & Green',
                'val_3_desc' => 'Disiplin 5S & ramah lingkungan.',
            ]);
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('management_messages', function (Blueprint $table) {
            if (Schema::hasColumn('management_messages', 'show_core_values')) {
                $table->dropColumn([
                    'show_core_values', 
                    'val_1_title', 
                    'val_1_desc', 
                    'val_2_title', 
                    'val_2_desc', 
                    'val_3_title', 
                    'val_3_desc'
                ]);
            }
        });
    }
};

