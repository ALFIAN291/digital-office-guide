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
        $response->assertSeeText('Pedoman Dos & Don\'ts');
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
}
