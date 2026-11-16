<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed public office guide reference data.
     * Administrator credentials are never hardcoded or seeded from repository files.
     */
    public function run(): void
    {
        $this->call(DigitalOfficeGuideSeeder::class);
    }
}
