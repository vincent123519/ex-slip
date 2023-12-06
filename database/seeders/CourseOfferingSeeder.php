<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseOffering;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\Department;
use Faker\Factory as Faker;

class CourseOfferingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Sample course data
        $sampleCourses = [
            // Add your sample courses here
        ];

        // Insert sample course data
        Course::insertOrIgnore($sampleCourses);

        // Check if there are teacher records
        $teacherCount = Teacher::count();

        if ($teacherCount > 0) {
            for ($i = 0; $i < 10; $i++) {
                // Retrieve a random course record
                $randomCourse = Course::inRandomOrder()->first();

                // Ensure a course record exists
                if ($randomCourse) {
                    // Retrieve a random teacher record
                    $randomTeacher = Teacher::inRandomOrder()->first();

                    // Ensure a teacher record exists
                    if ($randomTeacher) {
                        // Check if the course offering already exists
                        $existingOffering = CourseOffering::where([
                            'course_code' => $randomCourse->course_code,
                            'semester_id' => Semester::inRandomOrder()->first()->semester_id,
                            'teacher_id' => $randomTeacher->teacher_id,
                        ])->first();

                        if (!$existingOffering) {
                            // Generate a unique offer_code based on current timestamp and index
                            $uniqueOfferCode = time() + $i;

                            // Create a course offering with the unique offer_code
                            CourseOffering::create([
                                'offer_code' => $uniqueOfferCode,
                                'course_code' => $randomCourse->course_code,
                                'semester_id' => Semester::inRandomOrder()->first()->semester_id,
                                'teacher_id' => $randomTeacher->teacher_id,
                                'start_time' => $faker->time('H:i:s'),
                                'end_time' => $faker->time('H:i:s'),
                                'days_of_week' => $faker->randomElement(['MWF', 'TTH', 'MW', 'TH', 'F']),
                                'department_id' => Department::inRandomOrder()->first()->department_id,
                            ]);
                        }
                    }
                }
            }
        } else {
            // Handle the case where there are no teacher records
            echo "No teacher records found. Please create teacher records first.";
        }
    }
}
