<?php

namespace Database\Seeders;

use App\Models\RefResearchCoe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefResearchCoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefResearchCoe::factory()->count(5)->create();
    }
}
