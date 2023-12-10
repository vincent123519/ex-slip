<?php

namespace App\Http\Controllers;

use App\Models\Dean;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudyLoad;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use App\Models\DepartmentDegree;
use App\Models\Counselor; // Corrected import statement
use App\Models\User; // Assuming it is needed, please import the User model
use App\Models\Department; // Assuming it is needed, please import the Department model

class ExcuseSlipController extends Controller
{
    public function index()
    {
        $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')->get();
        return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    }

    public function createExcuseSlip()
{
    // Retrieve the necessary data for the form, including degree names
    $courses = Course::all();
    $teachers = Teacher::all();
    $counselors = Counselor::all();
    $deans = Dean::all();
    $excuseStatuses = ExcuseStatus::all();
    $yearLevel = auth()->user()->student->year_level;

    $user = auth()->user();

    // Fetch degree data to populate the dropdown
    $degrees = DepartmentDegree::all();
    $studentId=$user->student->student_id;

    // Retrieve the study load of the student with eager loading
    $studyLoad = StudyLoad::where('student_id', $studentId)->with('courseOffering.course')->get();

    // Create a new ExcuseSlip instance (assuming it's needed for the form)
    $excuseSlip = new ExcuseSlip();

    return view('excuseslip.create', compact('courses', 'teachers', 'counselors', 'deans', 'excuseStatuses', 'degrees', 'excuseSlip', 'yearLevel', 'studyLoad'));
}

public function store(Request $request)
{
    // Add some debugging statements
    dd($request->all()); // This will dump the form data for debugging

    // Validate the request data

    // Get the authenticated user
    $user = auth()->user();

    // Create a new excuse slip instance and fill it with the request data
    $excuseSlip = new ExcuseSlip();

    // Set the student_id based on the authenticated user
    $excuseSlip->student_id = $user->student->student_id; // Assuming this is the correct relationship structure

    // Set other fields based on the request data
    $excuseSlip->reason = $request->input('reason');
    $excuseSlip->start_date = $request->input('start_date');
    $excuseSlip->end_date = $request->input('end_date');
    $excuseSlip->status_id = $request->input('status_id');

    // Fetch the associated course offering based on the offer code
    $courseOffering = CourseOffering::where('offer_code', $request->input('offer_code'))->first();

    // Check if the course offering exists
    if ($courseOffering) {
        // Fetch the associated course
        $course = $courseOffering->course;

        // Check if the course exists
        if ($course) {
            // Fetch the associated teacher
            $teacher = $course->teacher;

            // Check if the teacher exists
            if ($teacher) {
                // Assign the teacher ID to the excuse slip
                $excuseSlip->teacher_id = $teacher->teacher_id;

                // Save the excuse slip to the database
                $excuseSlip->save();

                // Redirect the user to the student dashboard
                return redirect()->route('student.dashboard')->with('success', 'Excuse slip submitted successfully.');
            } else {
                // Handle the case when the teacher is not found
                return redirect()->back()->with('error', 'Teacher not found.');
            }
        } else {
            // Handle the case when the course is not found
            return redirect()->back()->with('error', 'Course not found.');
        }
    } else {
        // Handle the case when the CourseOffering is not found
        return redirect()->back()->with('error', 'Course offering not found.');
    }
}

    
    
    public function show($id)
    {
        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')->find($id);

        // Return the excuse slip details view with the retrieved data
        return view('excuseslip.show', ['excuseSlip' => $excuseSlip]);
    }


    public function edit($id)
    {
        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);
    
        // Check if $excuseSlip is not null before proceeding
        if (!$excuseSlip) {
            // Handle the case where $excuseSlip is not found
            // For example, redirect to an error page or return an error response
        }
    
        // Retrieve other necessary data for editing the excuse slip
    
        // Return the edit excuse slip form view with the retrieved data
        return view('excuseslip.edit', [
            'excuseSlip' => $excuseSlip,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'courses' => Course::all(),
            'counselors' => Counselor::all(),
            // Add other necessary data
        ]);
    }
    
    
    
    public function update(Request $request, $id)
    {
        // Validate the request data

        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);

        // Update the excuse slip with the new data
        $excuseSlip->student_id = $request->input('student_id');
        $excuseSlip->teacher_id = $request->input('teacher_id');
        $excuseSlip->counselor_id = $request->input('counselor_id');
        $excuseSlip->dean_id = $request->input('dean_id');
        $excuseSlip->course_code = $request->input('course_code');
        $excuseSlip->reason = $request->input('reason');
        $excuseSlip->start_date = $request->input('start_date');
        $excuseSlip->end_date = $request->input('end_date');
        $excuseSlip->status_id = $request->input('status_id');

        // Save the updated excuse slip to the database
        $excuseSlip->save();

        // Redirect the user to the excuse slip details page
        return redirect()->route('excuse_slips.show', ['id' => $excuseSlip->id]);
    }

    public function destroy($id)
    {
        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);

        // Delete the excuse slip from the database
        $excuseSlip->delete();

        // Redirect the user to the excuse slips list page
        return redirect()->route('excuse_slips.index');
    }
}
