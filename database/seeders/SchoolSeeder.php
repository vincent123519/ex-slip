<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $schools = [
            ['school_code' => 1001, 'school_name' => 'School of Computer Studies'],

            // Add more sample data here
        ];

        School::insert($schools);
    }
}