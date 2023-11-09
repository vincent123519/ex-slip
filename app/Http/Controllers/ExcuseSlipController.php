<?php

namespace App\Http\Controllers;

use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\ExcuseStatus;
use App\Models\Counselor; // Corrected import statement
use App\Models\User; // Assuming it is needed, please import the User model
use App\Models\Department; // Assuming it is needed, please import the Department model

class ExcuseSlipController extends Controller
{
    public function index()
    {
        // Retrieve all excuse slips from the database
        $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')->get();

        // Return the excuse slips view with the retrieved data
        return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    }

    public function create()
    {
        // Retrieve necessary data for creating a new excuse slip, such as the list of students, teachers, courses, and counselors
        $counselors = Counselor::all(); // Fetch all counselors
    
        // Return the create excuse slip form view with the retrieved data
        return view('excuseslip.create', [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'courses' => Course::all(),
            'statuses' => ExcuseStatus::all(),
            'counselors' => $counselors, // Pass the counselors data to the view
            // Add other necessary data
        ]);
    }
    

    public function store(Request $request)
    {
        // Validate the request data

        // Create a new excuse slip instance and fill it with the request data
        $excuseSlip = new ExcuseSlip();
        $excuseSlip->student_id = $request->input('student_id');
        $excuseSlip->teacher_id = $request->input('teacher_id');
        $excuseSlip->counselor_id = $request->input('counselor_id');
        $excuseSlip->dean_id = $request->input('dean_id');
        $excuseSlip->course_code = $request->input('course_code');
        $excuseSlip->reason = $request->input('reason');
        $excuseSlip->start_date = $request->input('start_date');
        $excuseSlip->end_date = $request->input('end_date');
        $excuseSlip->status_id = $request->input('status_id');

        // Save the excuse slip to the database
        $excuseSlip->save();

        // Redirect the user to the excuse slip details page
        return redirect()->route('excuse_slips.show', ['id' => $excuseSlip->id]);
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

        // Retrieve necessary data for editing the excuse slip, such as the list of students, teachers, courses, etc.

        // Return the edit excuse slip form view with the retrieved data
        return view('excuseslip.edit', [
            'excuseSlip' => $excuseSlip,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'courses' => Course::all(),
            'counselors' => Counselor::all(), // Corrected class name
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
