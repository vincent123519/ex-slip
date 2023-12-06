<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = [
            ['semester_name' => '1st sem'],
            ['semester_name' => '2nd sem'],
            ['semester_name' => 'Summer'],
            // Add more semester records here
        ];

        foreach ($semesters as $semesterData) {
            Semester::create($semesterData);
        }
    }
}
