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
        if (!Schema::hasTable('desk_cards')) {
            Schema::create('desk_cards', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('department');
                $table->string('sub_team')->nullable();
                $table->string('desk_number')->index();
                $table->string('floor')->default('2');
                $table->string('area')->default('Office Building');
                $table->timestamps();
            });
        }

        try {
            if (DB::table('desk_cards')->count() === 0) {
                $now = now();
                DB::table('desk_cards')->insert([
                    [
                        'name' => 'Bran',
                        'department' => 'IT Department',
                        'sub_team' => 'Infrastructure & Security',
                        'desk_number' => 'A-023',
                        'floor' => '2',
                        'area' => 'Office Building',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'name' => 'Siti Rahma',
                        'department' => 'Human Resources & GA',
                        'sub_team' => 'People & Culture',
                        'desk_number' => 'B-104',
                        'floor' => '1',
                        'area' => 'Office Building',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'name' => 'Andi Pratama',
                        'department' => 'Engineering & QA',
                        'sub_team' => 'Product Development',
                        'desk_number' => 'E-210',
                        'floor' => '2',
                        'area' => 'Office Building',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]);
            }
        } catch (\Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desk_cards');
    }
};
