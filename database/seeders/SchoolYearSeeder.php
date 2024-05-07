<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schoolyear;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        SchoolYear::create([
            'sy_id' => '2023-2024',
            'sy_name' => 'SY 2023-2024',
        ]);

        SchoolYear::create([
            'sy_id' => '2024-2025',
            'sy_name' => 'SY 2024-2025',
        ]);
        
       
    }
}