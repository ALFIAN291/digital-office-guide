<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('desk_cards') && !Schema::hasColumn('desk_cards', 'image_path')) {
            Schema::table('desk_cards', function (Blueprint $table) {
                $table->longText('image_path')->nullable()->after('area');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('desk_cards') && Schema::hasColumn('desk_cards', 'image_path')) {
            Schema::table('desk_cards', function (Blueprint $table) {
                $table->dropColumn('image_path');
            });
        }
    }
};
