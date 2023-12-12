<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;
use App\Models\Feedback;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselorController extends Controller
{
    public function viewExcuseSlip($excuseSlipId)
    {
        $counselor = Auth::user()->counselor;
        $excuseSlip = ExcuseSlip::where('excuse_slip_id', $excuseSlipId)
            ->where('counselor_id', $counselor->counselor_id)
            ->with('student', 'teacher', 'course', 'status', 'feedback', 'supportingDocuments')
            ->first();

        if (!$excuseSlip) {
            return response()->json(['error' => 'Excuse slip not found.'], 404);
        }

        return response()->json(['excuseSlip' => $excuseSlip]);
    }

    public function viewReports(Request $request)
    {
        $counselor = Auth::user()->counselor;

        // Retrieve reports based on department, status, or any other criteria
        $departmentId = $request->input('department_id');
        $statusId = $request->input('status_id');

        $excuseSlips = ExcuseSlip::where('counselor_id', $counselor->counselor_id)
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->whereHas('course.department', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                });
            })
            ->when($statusId, function ($query) use ($statusId) {
                $query->where('status_id', $statusId);
            })
            ->with('student', 'teacher', 'course', 'status', 'feedback', 'supportingDocuments')
            ->get();

        return response()->json(['excuseSlips' => $excuseSlips]);
    }

    public function giveFeedback(Request $request)
    {
        $counselor = Auth::user()->counselor;

        $request->validate([
            'excuse_slip_id' => 'required|exists:excuse_slips,excuse_slip_id,counselor_id,' . $counselor->counselor_id,
            'feedback_remarks' => 'required',
            'feedback_type' => 'required',
        ]);

            $feedback = new Feedback();
            $feedback->excuse_slip_id = $request->input('excuse_slip_id');
            $feedback->feedback_remarks = $request->input('feedback_remarks');
            $feedback->feedback_date = now();
            $feedback->sender_id = Auth::id();
            $feedback->feedback_type = $request->input('feedback_type');
            $feedback->save();

        return response()->json(['message' => 'Feedback submitted successfully.']);
    }
  // counselorcontroller
    
public function dashboard()
{
    $user = auth()->user()->counselor->counselor_id;

    $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course','status')
    ->select( 'excuse_slip_id','counselor_id', 'student_id' , 'reason', 'dean_id', 'teacher_id','start_date', 'course_code' ,'end_date', 'status_id')->get();

    $student = Student::all();
    return view('counselor.dashboard', ['excuseSlips' => $excuseSlips]);
}

public function approve($id)
{
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Update the status to 'approved' or use the appropriate logic
    $excuseSlip->update(['status_id' => '2']);

    return redirect()->back()->with('success', 'Excuse slip approved successfully.');
}

public function reject($id)
{
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Update the status to 'rejected' or use the appropriate logic
    $excuseSlip->update(['status_id' => '3']);

    return redirect()->back()->with('success', 'Excuse slip rejected successfully.');
}

    
    }