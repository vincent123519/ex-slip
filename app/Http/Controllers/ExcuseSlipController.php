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
    $user = auth()->user();
    $studentId = $user->student->student_id;
    $student = Student::find($studentId);
    $department = $student->degree->department;

    // Get the counselor and dean associated with the department
    $counselor = $department->counselor;
    $dean = $department->dean;

    // Retrieve the necessary data for the form, including degree names
    $excuseStatuses = ExcuseStatus::all();
    $yearLevel = $user->student->year_level;
    $degrees = DepartmentDegree::all();

    // Retrieve the study load of the student with eager loading
    $studyLoad = StudyLoad::where('student_id', $studentId)
        ->with('courseOffering.course.teacher')
        ->get();
    $teachers = $studyLoad->pluck('courseOffering.course.teacher')->unique();

    // Create a new ExcuseSlip instance
    $excuseSlip = new ExcuseSlip();

    return view('excuseslip.create', compact(
        'counselor',
        'dean',
        'teachers',
        'excuseStatuses',
        'degrees',
        'excuseSlip',
        'yearLevel',
        'studyLoad'
    ));
}   

public function store(Request $request)
{
            // Add some debugging statements
    dd($request->all()); // This will dump the form data for debugging

    // Validate the form data
    $validatedData = $request->validate([
        'student_id' => 'required',
        'teacher_id' => 'required',
        'counselor_id' => 'required',
        'dean_id' => 'required',
        'offer_code' => 'required',
        'reason' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'status_id' => 'required',
        // Add validation rules for any additional form fields
    ]);

    // Create a new ExcuseSlip instance
    $excuseSlip = new ExcuseSlip();

    // Set the values for the ExcuseSlip instance
    $excuseSlip->student_id = $validatedData['student_id'];
    $excuseSlip->teacher_id = $validatedData['teacher_id'];
    $excuseSlip->counselor_id = $validatedData['counselor_id'];
    $excuseSlip->dean_id = $validatedData['dean_id'];
    $excuseSlip->offer_code = $validatedData['offer_code'];
    $excuseSlip->reason = $validatedData['reason'];
    $excuseSlip->start_date = $validatedData['start_date'];
    $excuseSlip->end_date = $validatedData['end_date'];
    $excuseSlip->status_id = $validatedData['status_id'];
    // Set values for any additional fields

    // Save the ExcuseSlip instance
    $excuseSlip->save();

    // Redirect to the appropriate location after saving the excuse slip
    return redirect()->route('excuseslip.show', $excuseSlip->id)->with('success', 'Excuse slip created successfully!');
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
