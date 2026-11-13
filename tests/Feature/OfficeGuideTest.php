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
        $response->assertSeeText('Welcome to');
        $response->assertSeeText('Your New Workplace');
        $response->assertSeeText('A Message from');
        $response->assertSeeText('Explore Your Workplace');
        $response->assertSeeText('Office & Plant');
        $response->assertSeeText('Facilities');
        $response->assertSeeText('Office Map');
        $response->assertSeeText('Dos & Don\'ts');
    }

    public function test_message_page_returns_successful_response(): void
    {
        $response = $this->get('/message');
        $response->assertStatus(200);
        $response->assertSeeText('A Message from Management');
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
        $response->assertSeeText('Office Dos & Don\'ts');
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
        $this->get('/onboarding')->assertStatus(200)->assertSeeText('Your Onboarding Journey');
        $this->get('/canteen')->assertStatus(200)->assertSeeText('Canteen');
        $this->get('/visitor-guide')->assertStatus(200)->assertSeeText('Visitor Management');
        $this->get('/attendance')->assertStatus(200)->assertSeeText('Attendance');
        $this->get('/support')->assertStatus(200)->assertSeeText('Support');
    }

    public function test_admin_can_save_edit_and_print_desk_cards(): void
    {
        $admin = \App\Models\User::first() ?? \App\Models\User::factory()->create([
            'email' => 'admin@akebono-astra.co.id',
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
        $response->assertSeeText('How to Use');
        $response->assertSeeText('Book via SSO Portal');
    }

    public function test_map_page_renders_architectural_floor_controls(): void
    {
        $response = $this->get('/map?floor=Lantai+2');
        $response->assertStatus(200);
        $response->assertSeeText('Floor Plan');
        $response->assertSeeText('Get Direction');
    }
}
