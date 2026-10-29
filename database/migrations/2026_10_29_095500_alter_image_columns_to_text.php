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
        Schema::table('facilities', function (Blueprint $table) {
            $table->text('image_path')->nullable()->change();
        });

        Schema::table('management_messages', function (Blueprint $table) {
            $table->text('image_path')->nullable()->change();
        });

        if (Schema::hasTable('home_settings')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->text('hero_image')->nullable()->change();
                $table->text('card_office_image')->nullable()->change();
                $table->text('card_facilities_image')->nullable()->change();
                $table->text('card_map_image')->nullable()->change();
                $table->text('card_rules_image')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('image_path', 255)->nullable()->change();
        });

        Schema::table('management_messages', function (Blueprint $table) {
            $table->string('image_path', 255)->nullable()->change();
        });

        if (Schema::hasTable('home_settings')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->string('hero_image', 255)->nullable()->change();
                $table->string('card_office_image', 255)->nullable()->change();
                $table->string('card_facilities_image', 255)->nullable()->change();
                $table->string('card_map_image', 255)->nullable()->change();
                $table->string('card_rules_image', 255)->nullable()->change();
            });
        }
    }
};
