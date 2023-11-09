<?php

namespace App\Http\Controllers;

use App\Models\ExcuseSlip;
use App\Models\Student;
use App\Models\Course;
use App\Models\CourseOffering;

class ReportController extends Controller
{
    public function excuseSlipsByStudent()
    {
        $excuseSlipsByStudent = ExcuseSlip::select('student_id')
            ->selectRaw('COUNT(*) as total_excuse_slips')
            ->groupBy('student_id')
            ->get();

        return view('reports.excuse_slips_by_student', compact('excuseSlipsByStudent'));
    }

    public function excuseSlipsByCourse()
    {
        $excuseSlipsByCourse = ExcuseSlip::select('course_code')
            ->selectRaw('COUNT(*) as total_excuse_slips')
            ->groupBy('course_code')
            ->get();

        return view('reports.excuse_slips_by_course', compact('excuseSlipsByCourse'));
    }

    public function studentList()
    {
        $students = Student::all();

        return view('reports.student_list', compact('students'));
    }

    public function courseList()
    {
        $courses = Course::all();

        return view('reports.course_list', compact('courses'));
    }

    public function courseOfferingsBySemester($semesterId)
    {
        $courseOfferings = CourseOffering::where('semester_id', $semesterId)->get();

        return view('reports.course_offerings_by_semester', compact('courseOfferings'));
    }
}