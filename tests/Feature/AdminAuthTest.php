<?php

namespace Tests\Feature;

use App\Models\HomeSetting;
use App\Models\ManagementMessage;
use App\Models\User;
use Database\Seeders\DigitalOfficeGuideSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DigitalOfficeGuideSeeder::class);

        User::updateOrCreate(
            ['email' => 'admin@akebono.co.id'],
            [
                'name' => 'Akebono Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }

    public function test_guest_is_redirected_to_login_when_accessing_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $responseHome = $this->get('/admin/home');
        $responseHome->assertRedirect('/admin/login');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSeeText('Login Administrator');
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@akebono.co.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_succeeds_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@akebono.co.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_admin_can_access_dashboard_and_home_editor(): void
    {
        $user = User::where('email', 'admin@akebono.co.id')->first();

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText('Dashboard Administrator');

        $responseHome = $this->actingAs($user)->get('/admin/home');
        $responseHome->assertStatus(200);
        $responseHome->assertSeeText('Editor Konten Beranda');
    }

    public function test_admin_can_update_home_content(): void
    {
        $user = User::where('email', 'admin@akebono.co.id')->first();
        HomeSetting::current();

        $response = $this->actingAs($user)->post('/admin/home', [
            'office_title' => 'KARAWANG BARAT',
            'office_subtitle' => 'OFFICE & PLANT 2026',
            'hero_badge' => 'Pusat Keunggulan Sistem Rem',
            'hero_title_line1' => 'Selamat Datang di',
            'hero_title_line2' => 'Kantor Baru Akebono',
            'hero_tagline' => 'Bergerak Bersama. Bekerja Lebih Baik. Tumbuh Lebih Kuat.',
            'explore_title' => 'Jelajahi Kantor Anda',
            'card_office_title' => 'Kawasan Pabrik & Kantor',
            'card_office_badge' => 'Kampus Karawang',
            'card_facilities_title' => 'Semua Fasilitas',
            'card_facilities_badge' => 'Fasilitas Terpadu',
            'card_map_title' => 'Peta Denah Interaktif',
            'card_map_badge' => 'Denah Lantai 1 & 2',
            'card_rules_title' => 'Aturan K3 & Etiket',
            'card_rules_badge' => 'Zero Accident',
            'footnote_text' => 'Catatan: Foto merupakan ilustrasi resmi pabrik Karawang.',
            'safety_badge' => 'Keselamatan Utama',
            'safety_title' => 'Zero Accident',
            'safety_description' => 'Gunakan APD lengkap setiap saat.',
        ]);

        $response->assertRedirect('/admin/home');
        $response->assertSessionHas('success');

        // Check if database updated
        $this->assertDatabaseHas('home_settings', [
            'office_title' => 'KARAWANG BARAT',
            'hero_title_line2' => 'Kantor Baru Akebono',
        ]);

        // Check if public home page displays the updated content
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSeeText('KARAWANG BARAT');
        $homeResponse->assertSeeText('Kantor Baru Akebono');
        $homeResponse->assertSeeText('Bergerak Bersama. Bekerja Lebih Baik. Tumbuh Lebih Kuat.');
    }

    public function test_admin_can_update_management_message(): void
    {
        $user = User::where('email', 'admin@akebono.co.id')->first();

        $response = $this->actingAs($user)->post('/admin/message', [
            'title' => 'Pesan Khusus Dewan Direksi',
            'sender_name' => 'Presiden Direktur PT Akebono',
            'sender_role' => 'Board of Directors',
            'summary' => 'Memasuki babak baru fasilitas Karawang dengan semangat inovasi.',
            'content' => 'Fasilitas baru ini dirancang untuk mendukung masa depan kita semua.',
            'quote' => 'Moving Forward Together.',
        ]);

        $response->assertRedirect('/admin/message');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('management_messages', [
            'title' => 'Pesan Khusus Dewan Direksi',
            'summary' => 'Memasuki babak baru fasilitas Karawang dengan semangat inovasi.',
        ]);

        // Public page verification
        $publicResponse = $this->get('/');
        $publicResponse->assertSeeText('Pesan Khusus Dewan Direksi');
        $publicResponse->assertSeeText('Memasuki babak baru fasilitas Karawang dengan semangat inovasi.');
    }

    public function test_admin_can_logout(): void
    {
        $user = User::where('email', 'admin@akebono.co.id')->first();

        $response = $this->actingAs($user)->post('/admin/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}

