<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = [
            [
                'semester_name' => 'First Semester',
            ],
            [
                'semester_name' => 'Fall Semester',
            ],
            [
                'semester_name' => 'Summer',
            ],
            // Add more semester records here
        ];

        foreach ($semesters as $semesterData) {
            Semester::create($semesterData);
        }
    }
}