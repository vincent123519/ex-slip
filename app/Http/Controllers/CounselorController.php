<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Feedback;
use App\Models\Counselor;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;


use Illuminate\Http\Request;
use App\Models\CourseOffering;
use Illuminate\Support\Carbon;
use App\Models\CounselorFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExcuseSlipApprovedNotification;


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

// Controller
// Controller
public function dashboard(Request $request)
{
    $counselorId = auth()->user()->counselor->counselor_id;

    // Initialize the query for fetching excuse slips
    $query = ExcuseSlip::with('student', 'counselor', 'dean', 'courseOfferings.semester', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'created_at')
        ->where('counselor_id', $counselorId);

    // Get filter inputs
    $sortBy = $request->input('sort_by', 'today');
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $semesterId = $request->input('semester_id');
    $schoolYearId = $request->input('school_year_id');

    // Apply sorting filters
    switch ($sortBy) {
        case 'today':
            $query->whereDate('excuse_slips.created_at', today());
            break;

        case 'month':
            $query->whereYear('excuse_slips.created_at', $year)
                  ->whereMonth('excuse_slips.created_at', $month);
            break;

        case 'year':
            $query->whereYear('excuse_slips.created_at', $year);
            break;

            case 'weekly':
                // Use Carbon to filter the last 7 days
                $query->where('excuse_slips.updated_at', '>=', Carbon::now()->subDays(7));
                break;

        case 'semester':
            if ($semesterId) {
                $query->whereHas('courseOfferings', function ($subquery) use ($semesterId) {
                    $subquery->where('semester_id', $semesterId);
                });
            }
            break;

        case 'school_year':
            if ($schoolYearId) {
                $query->whereHas('courseOfferings.semester', function ($subquery) use ($schoolYearId) {
                    $subquery->where('sy_id', $schoolYearId);
                });
            }
            break;
    }

    // Execute the query
    $excuseSlips = $query->get();
    $latestExcuseSlips = $this->counselorNotification($counselorId);

    // Generate export URL with query parameters
    $exportUrl = route('excuse_slips.export', [
        'sort_by' => $sortBy,
        'month' => $month,
        'year' => $year,
        'semester_id' => $semesterId,
        'school_year_id' => $schoolYearId,
    ]);

    return view('counselor.dashboard', compact('excuseSlips', 'exportUrl', 'latestExcuseSlips'));
}


public function counselorNotification()
{
    $counselorId = auth()->user()->counselor->counselor_id;

    // Query for fetching the latest unread excuse slip for notification
    $notificationQuery = ExcuseSlip::with('student', 'counselor', 'dean', 'courses', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id','start_date', 'end_date', 'status_id', 'created_at','read_by_counselor')
        ->where('counselor_id', $counselorId)
        ->orderByDesc('created_at')
        ->get(); // Retrieve only the latest unread excuse slip for notification

    return $notificationQuery;
}

public function markAsRead($excuseSlipId)
    {
        $excuseSlip = ExcuseSlip::find($excuseSlipId);
        if ($excuseSlip) {
            $excuseSlip->read_by_counselor = true;
            $excuseSlip->save();
        }

        return redirect()->back();
    }


public function approve($id)
{
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Update the status to 'approved' or use the appropriate logic
    $excuseSlip->update(['status_id' => '2']);

    // Retrieve the dean's email address
    $deanEmail = $excuseSlip->dean->email;

    // Notify the dean
    // if ($deanEmail) {
    //     Notification::route('mail', $deanEmail)
    //         ->notify(new ExcuseSlipApprovedNotification($excuseSlip));
    // }

    // Redirect back to the dashboard after approving
    return redirect()->route('counselor.dashboard')->with('success', 'Excuse slip approved successfully.');
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

    
    