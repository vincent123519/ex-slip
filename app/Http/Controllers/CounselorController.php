<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Student;
use App\Models\Feedback;
use App\Models\Counselor;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CounselorFeedback;
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
    public function dashboard(Request $request)
    {
        $counselorId = auth()->user()->counselor->counselor_id;
    
        // Query for fetching excuse slips
        $query = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')
            ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'teacher_id', 'start_date', 'course_code', 'end_date', 'status_id')
            ->where('counselor_id', $counselorId);
    
        // Sorting logic based on the request parameter
        $sort_by = $request->input('sort_by', 'day');
    
        switch ($sort_by) {
            case 'month':
                // Filter by the selected month
                $month = $request->input('month', date('m')); // Default to current month
                $query->whereMonth('created_at', $month);
                break;
            case 'year':
                // Filter by the selected year
                $year = $request->input('year', date('Y')); // Default to current year
                $query->whereYear('created_at', $year);
                break;
            default:
                // For 'day' or other cases, no additional filtering needed
                break;
        }
    
        $excuseSlips = $query->get();
    
        // Format the created_at field in each ExcuseSlip to exclude hours, minutes, and seconds
        foreach ($excuseSlips as $excuseSlip) {
            $excuseSlip->formatted_created_at = Carbon::parse($excuseSlip->created_at)->format('Y-m-d'); // Format the date
        }
    
        return view('counselor.dashboard', compact('excuseSlips'));
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
    public function storeCounselorFeedback(Request $request)
{
    // Validate the request

    CounselorFeedback::create([
        'excuse_slip_id' => $request->excuse_slip_id,
        'counselor_id' => auth()->user()->id, // Assuming counselor is the authenticated user
        'remarks' => $request->remarks,
        // Add other fields as needed
    ]);
}

public function storeFeedback(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'feedback_remarks' => 'required|string|max:255',
    ]);

    // Find the excuse slip by ID
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Check if the authenticated user is a counselor and associated with the excuse slip
    if (auth()->user()->role_id == 4 && auth()->user()->counselor->counselor_id === $excuseSlip->counselor_id) {
        // Store the feedback in the database
        $excuseSlip->counselorFeedbacks()->create([
            'remarks' => $request->input('feedback_remarks'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    } else {
        // Unauthorized action, redirect with an error message
        abort(403, 'Unauthorized action.');
    }
}

}

    
    