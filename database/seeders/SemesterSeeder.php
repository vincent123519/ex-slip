<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;
use App\Models\SchoolYear;

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

        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        if ($activeSchoolYear) {
            $syId = $activeSchoolYear->sy_id;
            $syName = $activeSchoolYear->sy_name;

            foreach ($semesters as $semesterData) {
                $semesterData['semester_name'] = $syName . ' ' . $semesterData['semester_name'];
                $semesterData['sy_id'] = $syId;
                Semester::create($semesterData);
            }
        }
    }
}