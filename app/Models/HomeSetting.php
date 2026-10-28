<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'office_title',
        'office_subtitle',
        'hero_badge',
        'hero_title_line1',
        'hero_title_line2',
        'hero_tagline',
        'hero_image',
        'explore_title',
        'card_office_title',
        'card_office_badge',
        'card_office_image',
        'card_facilities_title',
        'card_facilities_badge',
        'card_facilities_image',
        'card_map_title',
        'card_map_badge',
        'card_map_image',
        'card_rules_title',
        'card_rules_badge',
        'card_rules_image',
        'footnote_text',
        'safety_badge',
        'safety_title',
        'safety_description',
    ];

    /**
     * Singleton helper to get the active settings.
     */
    public static function current(): self
    {
        return self::firstOrCreate([], [
            'office_title' => 'KARAWANG',
            'office_subtitle' => 'OFFICE GUIDE 2026',
            'hero_badge' => 'Karawang Plant & Office Complex',
            'hero_title_line1' => 'Welcome to',
            'hero_title_line2' => 'Your New Workplace',
            'hero_tagline' => 'Moving Together. Working Better. Growing Stronger.',
            'hero_image' => '/images/hero-office.jpg',
            'explore_title' => 'Explore Your Workplace',
            'card_office_title' => 'Office & Plant',
            'card_office_badge' => 'Kampus Terpadu',
            'card_office_image' => '/images/plant-exterior.jpg',
            'card_facilities_title' => 'Facilities',
            'card_facilities_badge' => 'Fasilitas Kerja',
            'card_facilities_image' => '/images/facilities-office.jpg',
            'card_map_title' => 'Office Map',
            'card_map_badge' => 'Denah Interaktif',
            'card_map_image' => '/images/floorplan-preview.jpg',
            'card_rules_title' => "Dos & Don'ts",
            'card_rules_badge' => 'Panduan K3 & Etiket',
            'card_rules_image' => '/images/meeting-room.jpg',
            'footnote_text' => 'Visual kantor merupakan ilustrasi konseptual. Ganti dengan foto aktual setelah tersedia.',
            'safety_badge' => 'Standar Keselamatan Karawang',
            'safety_title' => 'Zero Accident & Budaya 5S',
            'safety_description' => 'Patuhi jalur hijau dan pastikan APD terpasang dengan baik sebelum melangkah ke area pabrik.',
        ]);
    }
}

