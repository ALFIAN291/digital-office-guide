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
            if (!Schema::hasColumn('home_settings', 'message_display_mode')) {
                $table->string('message_display_mode')->default('popup'); // 'popup' or 'card'
            }
            if (!Schema::hasColumn('home_settings', 'message_auto_popup')) {
                $table->boolean('message_auto_popup')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (Schema::hasColumn('home_settings', 'message_display_mode')) {
                $table->dropColumn('message_display_mode');
            }
            if (Schema::hasColumn('home_settings', 'message_auto_popup')) {
                $table->dropColumn('message_auto_popup');
            }
        });
    }
};
