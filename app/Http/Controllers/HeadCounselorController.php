<?php

namespace App\Http\Controllers;

use App\Models\HeadCounselor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class HeadCounselorController extends Controller
{
    public function assignCounselor(Request $request)
    {
        // Retrieve the form inputs
        $headCounselorId = $request->input('head_counselor_id');
        $departmentId = $request->input('department_id');

        // Find the head counselor and department models
        $headCounselor = HeadCounselor::find($headCounselorId);
        $department = Department::find($departmentId);

        // Assign the head counselor to the department
        $headCounselor->department()->associate($department);
        $headCounselor->save();

        // Redirect or return a response
        // ...
    }

    public function showAssignForm()
    {
        $headCounselors = HeadCounselor::all();
        $departments = Department::all();
    
        return view('headcounselor.assign', compact('headCounselors', 'departments'));
    }

    public function index()
    {
        $headCounselors = HeadCounselor::with('user', 'department')->get();
    
        return view('headcounselor.index', compact('headCounselors'));
    }

    // Other methods for managing head counselors
}