<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Department;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'course_code' => 'IPT1',
                'course_name' => 'Integrated Programming',
                'department_id' => 1,
            ],
            [
                'course_code' => 'IM1',
                'course_name' => 'Information Management 1',
                'department_id' => 1,
            ],
            [
                'course_code' => 'ICRPOG 1',
                'course_name' => 'Computer PRogramming 1',
                'department_id' => 1,
            ],
            [
                'course_code' => 'IAS1',
                'course_name' => 'Information Assurance and Security 1',
                'department_id' => 1,
            ],
            [
                'course_code' => 'CivE 01',
                'course_name' => 'Civil Engineering 1',
                'department_id' => 2,
            ],
            
            // Add more course records here
        ];

                    

        foreach ($courses as $courseData) {
            // Check if the course already exists
            $existingCourse = Course::where('course_code', $courseData['course_code'])->first();

            if (!$existingCourse) {
                $course = Course::create($courseData);

                // Retrieve the department for the course
                $department = Department::find($courseData['department_id']);

                // Associate the course with the department
                $course->department()->associate($department);
                $course->save();
            }
        }
    }
}
