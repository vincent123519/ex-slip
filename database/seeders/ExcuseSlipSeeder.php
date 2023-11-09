<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\ExcuseSlip;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Counselor;
use App\Models\Dean;
use App\Models\Course;
use App\Models\ExcuseStatus;

class ExcuseSlipSeeder extends Seeder
{
    public function run()
    {
        // Create sample data for relationships
        $students = Student::pluck('student_id');
        $teachers = Teacher::pluck('teacher_id');
        $counselors = Counselor::pluck('counselor_id');
        $deans = Dean::pluck('dean_id');
        $courses = Course::pluck('course_code');
        $statuses = ExcuseStatus::pluck('status_id');
        
        if ($students->isEmpty() || $teachers->isEmpty() || $counselors->isEmpty() || $deans->isEmpty() || $courses->isEmpty() || $statuses->isEmpty()) {
            // Handle the case where one or more collections are empty
            // You can log an error, display a message, or take appropriate action
            // For this example, we'll simply return and not create any ExcuseSlips
            return;
        }

        $excuseSlips = [
            [
                'student_id' => $students->random(),
                'teacher_id' => $teachers->random(),
                'counselor_id' => $counselors->random(),
                'dean_id' => $deans->random(),
                'course_code' => $courses->random(),
                'reason' => 'Medical leave',
                'start_date' => '2023-09-01',
                'end_date' => '2023-09-05',
                'status_id' => $statuses->random(),
            ],
            [
                'student_id' => $students->random(),
                'teacher_id' => $teachers->random(),
                'counselor_id' => $counselors->random(),
                'dean_id' => $deans->random(),
                'course_code' => $courses->random(),
                'reason' => 'Family emergency',
                'start_date' => '2023-09-10',
                'end_date' => '2023-09-12',
                'status_id' => $statuses->random(),
            ],
            // Add more sample data as needed
        ];

        foreach ($excuseSlips as $excuseSlip) {
            ExcuseSlip::create($excuseSlip);
        }
    }
}
