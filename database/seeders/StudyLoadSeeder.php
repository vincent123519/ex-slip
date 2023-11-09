<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyLoad;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Course;
use App\Models\CourseOffering;

class StudyLoadSeeder extends Seeder
{
    public function run()
    {
        // Sample data for StudyLoad table
        $studyLoads = [
            [
                'student_id' => 2,
                'semester_id' => 1,
                'course_code' => 'CSE101',
                'offer_code' => 1001,
            ],
            [
                'student_id' => 2,
                'semester_id' => 1,
                'course_code' => 'MAT201',
                'offer_code' => 1002,
            ],
            // Add more sample data here
        ];

        foreach ($studyLoads as $studyLoadData) {
            $student = Student::find($studyLoadData['student_id']);
            $semester = Semester::find($studyLoadData['semester_id']);
            $course = Course::where('course_code', $studyLoadData['course_code'])->first();
            $courseOffering = CourseOffering::find($studyLoadData['offer_code']);

            if ($student && $semester && $course && $courseOffering) {
                $studyLoad = new StudyLoad();
                $studyLoad->student()->associate($student);
                $studyLoad->semester()->associate($semester);
                $studyLoad->course()->associate($course);
                $studyLoad->courseOffering()->associate($courseOffering);
                $studyLoad->save();
            }
        }
    }
}