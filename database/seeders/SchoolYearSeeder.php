<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolYear;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        SchoolYear::create([
            'sy_id' => '2023-2024',
            'sy_name' => 'SY 2023-2024',
            'is_active' => true,
        ]);

        SchoolYear::create([
            'sy_id' => '2024-2025',
            'sy_name' => 'SY 2024-2025',
            'is_active' => false,
        ]);

        SchoolYear::create([
            'sy_id' => '2025-2026',
            'sy_name' => 'SY 2025-2026',
            'is_active' => false,
        ]);

        SchoolYear::create([
            'sy_id' => '2026-2027',
            'sy_name' => 'SY 2026-2027',
            'is_active' => false,
        ]);

    }
}