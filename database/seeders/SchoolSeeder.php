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
            ['school_code' => 1003, 'school_name' => 'School of Business Management'],
            ['school_code' => 1002, 'school_name' => 'School of Engineering'],
            ['school_code' => 1004, 'school_name' => 'School of Arts and Science'],

            // Add more sample data here
        ];

        foreach ($schools as $school) {
            // Check if the school_code already exists
            if (!School::where('school_code', $school['school_code'])->exists()) {
                School::create($school);
            }
        }
    }
}
