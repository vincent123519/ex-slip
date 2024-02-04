<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\HeadCounselor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class HeadCounselorController extends Controller
{
    public function assignCounselor(Request $request)
{
    // Retrieve the form inputs
    $counselorId = $request->input('counselor_id');
    $departmentId = $request->input('department_id');

    // Find the counselor and department models
    $counselor = Counselor::find($counselorId);
    $department = Department::find($departmentId);

    // Check if both models were found
    if (!$counselor) {
        // Handle the case where the counselor was not found
        return back()->with('error', 'Counselor not found');
    }

    if (!$department) {
        // Handle the case where the department was not found
        return back()->with('error', 'Department not found');
    }

    // Update the counselor's department
    $counselor->department_id = $departmentId;
    $counselor->save();

    // Redirect with success message
    return redirect()->route('assign-counselor')->with('success', 'Counselor assigned successfully');
}


    public function showAssignForm()
    {
        $Counselors = Counselor::all();
        $departments = Department::all();
    
        return view('headcounselor.assign', compact('Counselors', 'departments'));
    }

    public function index()
    {
        $Counselors = Counselor::with('user', 'department')->get();
    
        return view('counselor.index', compact('Counselors'));
    }

    // Other methods for managing head counselors
}