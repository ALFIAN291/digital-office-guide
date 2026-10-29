<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('home_settings', 'hero_height')) {
                $table->string('hero_height')->default('pendek');
            }
            if (!Schema::hasColumn('home_settings', 'message_height')) {
                $table->string('message_height')->default('pendek');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (Schema::hasColumn('home_settings', 'hero_height')) {
                $table->dropColumn('hero_height');
            }
            if (Schema::hasColumn('home_settings', 'message_height')) {
                $table->dropColumn('message_height');
            }
        });
    }
};
