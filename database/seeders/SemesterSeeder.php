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

        $schoolYears = SchoolYear::all();

        foreach ($schoolYears as $schoolYear) {
            foreach ($semesters as $semesterData) {
                $semesterData['semester_name'] = $schoolYear->sy_name . ' ' . $semesterData['semester_name'];
                $semesterData['sy_id'] = $schoolYear->sy_id;
                Semester::create($semesterData);
            }
        }
    }
}