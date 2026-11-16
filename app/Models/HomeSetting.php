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
        'hero_height',
        'message_height',
        'message_display_mode',
        'message_auto_popup',
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
            'office_subtitle' => 'PANDUAN KANTOR 2026',
            'hero_badge' => 'Kompleks Kantor & Pabrik Karawang',
            'hero_title_line1' => 'Selamat Datang di',
            'hero_title_line2' => 'Lingkungan Kerja Baru Anda',
            'hero_tagline' => 'Melangkah Bersama. Bekerja Lebih Baik. Tumbuh Lebih Kuat.',
            'hero_image' => '/images/hero-office.jpg',
            'hero_height' => 'pendek',
            'message_height' => 'pendek',
            'message_display_mode' => 'popup',
            'message_auto_popup' => true,
            'explore_title' => 'Jelajahi Lingkungan Kerja Anda',
            'card_office_title' => 'Kantor & Pabrik',
            'card_office_badge' => 'Kampus Terpadu',
            'card_office_image' => '/images/plant-exterior.jpg',
            'card_facilities_title' => 'Fasilitas',
            'card_facilities_badge' => 'Fasilitas Kerja',
            'card_facilities_image' => '/images/facilities-office.jpg',
            'card_map_title' => 'Denah Kantor',
            'card_map_badge' => 'Denah Interaktif',
            'card_map_image' => '/images/floorplan-preview.jpg',
            'card_rules_title' => 'Etiket & Aturan (K3)',
            'card_rules_badge' => 'Panduan K3 & Etiket',
            'card_rules_image' => '/images/meeting-room.jpg',
            'footnote_text' => 'Visual kantor merupakan ilustrasi konseptual. Ganti dengan foto aktual setelah tersedia.',
            'safety_badge' => 'Standar Keselamatan Karawang',
            'safety_title' => 'Nihil Kecelakaan & Budaya 5R',
            'safety_description' => 'Patuhi jalur hijau dan pastikan APD terpasang dengan baik sebelum melangkah ke area pabrik.',
        ]);
    }
}

