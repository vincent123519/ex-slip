<?php

namespace App\Http\Controllers;

use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Dean;
use App\Models\DepartmentDegree;
use App\Models\ExcuseStatus;
use App\Models\Counselor; 
use App\Models\User; 
use App\Models\Department; 
use Illuminate\Support\Facades\Auth;
class ExcuseSlipController extends Controller
{
    // public function index()
    // {
    //     $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')->get();
    //     return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    // }

    // public function index()
    // {
    //     // $studentId = auth()->user()->student->student_id;

    //     // Retrieve only the excuse slips for the logged-in student
    //     $excuseSlips = ExcuseSlip::select('start_date', 'end_date', 'status_id')->get();

    //     return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    // }

    public function studentExcuseSlipList()
    {
        // $studentId = auth()->user()->student->student_id;

        // Retrieve only the excuse slips for the logged-in student
        $excuseSlips = ExcuseSlip::select('start_date', 'end_date', 'status_id')->get();
  


        return view ('student.dashboard', ['excuseSlips' => $excuseSlips]);
    }

    public function createExcuseSlip()
    {
       
        $courses = Course::all();
        $teachers = Teacher::all();
        $counselors = Counselor::all();
        $deans = Dean::all();
        $excuseStatuses = ExcuseStatus::all();
        $yearLevel = auth()->user()->student->year_level;

        // Fetch degree data to populate the dropdown
        $degrees = DepartmentDegree::all(); // Assuming you have a model for DepartmentDegree
    
        // Fetch teacher, dean, and counselor data
        $coursesData = Course::select('course_code', 'course_name')->get();
        $teacherData = Teacher::select('teacher_id', 'name')->get();
        $deanData = Dean::select('dean_id', 'name')->get();
        $counselorData = Counselor::select('counselor_id', 'name')->get();


        // Create a new ExcuseSlip instance (assuming it's needed for the form)
        $excuseSlip = new ExcuseSlip();
    
        return view('excuseslip.create', compact('courses', 'teachers', 'counselors', 'deans', 'excuseStatuses', 'degrees', 'excuseSlip', 'yearLevel', 'coursesData', 'teacherData', 'deanData', 'counselorData'));
    }
    
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'student_id' => 'required',
            'teacher_id'=> 'required',
            'counselor_id'=> 'required',
            'dean_id' => 'required',
            'course_code' => 'required',
            'reason' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // 'status_id' => 'required',
        ]);

        $validatedData['status_id'] = 1;

     // Create the excuse slip request
     $excuseSlip = ExcuseSlip::create($validatedData);

    
     session([
        'success' => 'Excuse slip request created successfully.',
        'start_date' => $excuseSlip->start_date,
        'end_date' => $excuseSlip->end_date,
    ]);

    // // Debugging
    // dd('Redirecting...');

    // Redirect to the student dashboard
    return redirect()->route('student.dashboard')->withInput()->withErrors($validatedData);
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