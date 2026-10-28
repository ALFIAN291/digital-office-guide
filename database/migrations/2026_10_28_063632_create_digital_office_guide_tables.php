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
        Schema::create('management_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('A Message from Management');
            $table->string('sender_name')->nullable();
            $table->string('sender_role')->nullable();
            $table->text('summary');
            $table->longText('content');
            $table->string('quote')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // workspace, meeting, wellness, dining, service, safety
            $table->string('floor'); // Lantai 1, Lantai 2, Plant Area, Outdoor
            $table->string('location_detail')->nullable();
            $table->string('capacity')->nullable();
            $table->string('operating_hours')->nullable();
            $table->text('description');
            $table->text('guidelines')->nullable();
            $table->json('amenities')->nullable();
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('dos_and_donts', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // HSE & Keselamatan, Etiket Kerja & Lingkungan, Keamanan Informasi & TI, Penggunaan Fasilitas
            $table->enum('type', ['do', 'dont']);
            $table->string('title');
            $table->text('description');
            $table->string('tip_or_consequence')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('office_zones', function (Blueprint $table) {
            $table->id();
            $table->string('building'); // Gedung Utama, Plant 1, Plant 2, Fasilitas Penunjang
            $table->string('floor'); // Lantai 1, Lantai 2, Ground, Mezzanine
            $table->string('code')->nullable(); // MO-101, MR-SAKURA, etc.
            $table->string('name');
            $table->string('type'); // meeting, workstation, canteen, clinic, musholla, restroom, emergency
            $table->decimal('coord_x', 5, 2)->default(50.00); // 0.00 - 100.00%
            $table->decimal('coord_y', 5, 2)->default(50.00); // 0.00 - 100.00%
            $table->text('description')->nullable();
            $table->string('contact_person')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('extension')->nullable();
            $table->string('location')->nullable();
            $table->string('operating_hours')->default('24/7');
            $table->boolean('is_hotline')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
        Schema::dropIfExists('office_zones');
        Schema::dropIfExists('dos_and_donts');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('management_messages');
    }
};
