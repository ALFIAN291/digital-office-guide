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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            
            // Header Branding
            $table->string('office_title')->default('KARAWANG');
            $table->string('office_subtitle')->default('OFFICE GUIDE 2026');

            // Hero Section
            $table->string('hero_badge')->default('Karawang Plant & Office Complex');
            $table->string('hero_title_line1')->default('Welcome to');
            $table->string('hero_title_line2')->default('Your New Workplace');
            $table->string('hero_tagline')->default('Moving Together. Working Better. Growing Stronger.');
            $table->string('hero_image')->default('/images/hero-office.jpg');

            // Explore Workplace Section Title
            $table->string('explore_title')->default('Explore Your Workplace');

            // Card 1: Office & Plant
            $table->string('card_office_title')->default('Office & Plant');
            $table->string('card_office_badge')->default('Kampus Terpadu');
            $table->string('card_office_image')->default('/images/plant-exterior.jpg');

            // Card 2: Facilities
            $table->string('card_facilities_title')->default('Facilities');
            $table->string('card_facilities_badge')->default('Fasilitas Kerja');
            $table->string('card_facilities_image')->default('/images/facilities-office.jpg');

            // Card 3: Office Map
            $table->string('card_map_title')->default('Office Map');
            $table->string('card_map_badge')->default('Denah Interaktif');
            $table->string('card_map_image')->default('/images/floorplan-preview.jpg');

            // Card 4: Dos & Don'ts
            $table->string('card_rules_title')->default("Dos & Don'ts");
            $table->string('card_rules_badge')->default('Panduan K3 & Etiket');
            $table->string('card_rules_image')->default('/images/meeting-room.jpg');

            // Footnote
            $table->string('footnote_text')->default('Visual kantor merupakan ilustrasi konseptual. Ganti dengan foto aktual setelah tersedia.');

            // Safety Highlight Banner
            $table->string('safety_badge')->default('Standar Keselamatan Karawang');
            $table->string('safety_title')->default('Zero Accident & Budaya 5S');
            $table->text('safety_description')->default('Patuhi jalur hijau dan pastikan APD terpasang dengan baik sebelum melangkah ke area pabrik.');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
