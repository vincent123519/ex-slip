<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolYear;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        SchoolYear::create([
            'sy_id' => '2024-2025',
            'sy_name' => 'SY 2024-2025',
            'is_active' => true,
        ]);

    }
}