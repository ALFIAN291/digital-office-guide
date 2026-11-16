<?php

namespace Tests\Feature;

use Database\Seeders\DigitalOfficeGuideSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficeGuideTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DigitalOfficeGuideSeeder::class);
    }

    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Selamat Datang di');
        $response->assertSeeText('Lingkungan Kerja Baru Anda');
        $response->assertSeeText('Pesan dari Manajemen');
        $response->assertSeeText('Jelajahi Lingkungan Kerja Anda');
        $response->assertSeeText('Kantor & Pabrik');
        $response->assertSeeText('Fasilitas');
        $response->assertSeeText('Denah Kantor');
        $response->assertSeeText('Etiket & Aturan (K3)');
    }

    public function test_message_page_returns_successful_response(): void
    {
        $response = $this->get('/message');
        $response->assertStatus(200);
        $response->assertSeeText('Pesan dari Manajemen');
    }

    public function test_facilities_page_returns_successful_response(): void
    {
        $response = $this->get('/facilities');
        $response->assertStatus(200);
        $response->assertSeeText('Fasilitas Kantor & Pabrik');
    }

    public function test_facility_detail_page_returns_successful_response(): void
    {
        $response = $this->get('/facilities/ruang-rapat-sakura');
        $response->assertStatus(200);
        $response->assertSeeText('Sakura');
    }

    public function test_map_page_returns_successful_response(): void
    {
        $response = $this->get('/map');
        $response->assertStatus(200);
        $response->assertSeeText('Denah Kantor & Pabrik Karawang');
    }

    public function test_dos_and_donts_page_returns_successful_response(): void
    {
        $response = $this->get('/dos-and-donts');
        $response->assertStatus(200);
        $response->assertSeeText('Etiket & Tata Tertib Kantor');
    }

    public function test_office_and_plant_page_returns_successful_response(): void
    {
        $response = $this->get('/office-and-plant');
        $response->assertStatus(200);
        $response->assertSeeText('Kawasan Kantor & Pabrik Karawang');
    }

    public function test_emergency_page_returns_successful_response(): void
    {
        $response = $this->get('/emergency');
        $response->assertStatus(200);
        $response->assertSeeText('Kontak Darurat');
    }

    public function test_api_search_returns_json(): void
    {
        $response = $this->get('/api/search?q=sakura');
        $response->assertStatus(200);
        $response->assertJsonStructure(['facilities', 'rules', 'zones']);
    }

    public function test_concept_routes_return_successful_responses(): void
    {
        $this->get('/onboarding')->assertStatus(200)->assertSeeText('Panduan Orientasi Karyawan Anda');
        $this->get('/canteen')->assertStatus(200)->assertSeeText('Panduan Kantin');
        $this->get('/visitor-guide')->assertStatus(200)->assertSeeText('Manajemen Tamu & Resepsionis Virtual');
        $this->get('/attendance')->assertStatus(200)->assertSeeText('Panduan Absensi & Jam Kerja');
        $this->get('/support')->assertStatus(200)->assertSeeText('Pusat Bantuan & Kontak Internal');
    }

    public function test_admin_can_save_edit_and_print_desk_cards(): void
    {
        $admin = \App\Models\User::first() ?? \App\Models\User::factory()->create([
            'email' => 'test-admin@example.com',
        ]);

        $this->actingAs($admin)
            ->get('/admin/desks')
            ->assertStatus(200)
            ->assertSeeText('Desk QR Onboarding & Tent Card');

        $storeResponse = $this->actingAs($admin)->post('/admin/desks', [
            'name' => 'Rizky Pratama',
            'department' => 'Engineering Department',
            'sub_team' => 'Brake Design',
            'desk_number' => 'C-301',
            'floor' => '2',
            'area' => 'Office Building',
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('desk_cards', [
            'desk_number' => 'C-301',
            'name' => 'Rizky Pratama',
        ]);

        $desk = \App\Models\DeskCard::where('desk_number', 'C-301')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/desks/' . $desk->id . '/print')
            ->assertStatus(200)
            ->assertSeeText('Rizky Pratama')
            ->assertSeeText('C-301')
            ->assertSeeText('WELCOME TO');

        // Verify scanning QR loads the saved employee profile on home page
        $this->get('/?desk=C-301')
            ->assertStatus(200)
            ->assertSee('Rizky Pratama');
    }

    public function test_facility_detail_includes_how_to_use_steps(): void
    {
        $response = $this->get('/facilities/ruang-rapat-sakura');
        $response->assertStatus(200);
        $response->assertSeeText('Cara Menggunakan');
        $response->assertSeeText('Portal SSO');
    }

    public function test_map_page_renders_architectural_floor_controls(): void
    {
        $response = $this->get('/map?floor=Lantai+2');
        $response->assertStatus(200);
        $response->assertSeeText('Denah Lantai');
        $response->assertSeeText('Petunjuk Arah');
    }

    public function test_base64_db_images_are_served_via_media_endpoint_not_inlined(): void
    {
        $pngBytes = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=',
            true
        );
        $dataUri = 'data:image/png;base64,' . base64_encode($pngBytes);

        $message = \App\Models\ManagementMessage::firstOrFail();
        $message->update(['image_path' => $dataUri]);

        $homeSettings = \App\Models\HomeSetting::current();
        $homeSettings->update(['hero_image' => $dataUri]);

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertDontSee('data:image/png;base64,');
        $homeResponse->assertSee('/media/message/' . $message->id . '/image_path');
        $homeResponse->assertSee('/media/home/' . $homeSettings->id . '/hero_image');

        $mediaResponse = $this->get('/media/message/' . $message->id . '/image_path');
        $mediaResponse->assertStatus(200);
        $mediaResponse->assertHeader('Content-Type', 'image/png');
        $this->assertSame($pngBytes, $mediaResponse->getContent());

        $this->get('/media/home/' . $homeSettings->id . '/hero_image')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/png');

        $this->get('/media/unknown/' . $message->id . '/image_path')->assertStatus(404);
        $this->get('/media/message/' . $message->id . '/title')->assertStatus(404);
    }
}
