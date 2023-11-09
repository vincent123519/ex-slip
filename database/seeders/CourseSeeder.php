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
                'course_code' => 'CSE101',
                'course_name' => 'Introduction to Computer Science',
                'department_id' => 1,
            ],
            [
                'course_code' => 'MAT201',
                'course_name' => 'Calculus 1',
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
