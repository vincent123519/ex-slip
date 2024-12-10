<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExcuseSlipSignedNotification;

class TeacherController extends Controller
{
    public function viewExcuseSlips(Request $request)
    {
        $teacherId = $request->user()->teacher->teacher_id;

        $excuseSlips = ExcuseSlip::where('teacher_id', $teacherId)->with('student', 'course')->get();

        return view('excuse_slips.index', compact('excuseSlips'));
    }
    
    public function signExcuseSlip(Request $request, $excuseSlipId)
{
    // Find the excuse slip with its course offerings
    $excuseSlip = ExcuseSlip::with('courseOfferings')->findOrFail($excuseSlipId);

    // Get the authenticated teacher's ID
    $teacherId = $request->user()->teacher->teacher_id;

    // Get all offer codes that match the authenticated teacher
    $offerCodes = $excuseSlip->courseOfferings()
        ->where('course_offerings.teacher_id', $teacherId) // Ensure to specify the table
        ->pluck('course_offerings.offer_code'); // Get all matching offer codes

    // Check if there are any offer codes for the teacher
    if ($offerCodes->isNotEmpty()) {
        // Update the is_remark_by_teacher field for all matching offer codes
        $updated = DB::table('course_excuse_slip')
            ->where('excuse_slip_id', $excuseSlipId)
            ->whereIn('offer_code', $offerCodes) // Use whereIn to update all matching offer codes
            ->update(['is_remark_by_teacher' => 1]);

        // Log the update result
        Log::info('Update Result', ['updated_rows' => $updated]);

        // Check if the update was successful
        if ($updated) {
            return redirect()->route('teacher.dashboard')->with('success', 'Course offerings signed successfully.');
        }
    } else {
        return redirect()->back()->with('error', 'No offer codes found for the authenticated teacher.');
    }

    return redirect()->back()->with('error', 'Failed to sign the course offerings.');
}
public function dashboard()
{
    // Get the teacher's ID from the authenticated user
    $teacherId = auth()->user()->teacher->teacher_id;

    // Query for excuse slips associated with the teacher via the course_excuse_slip table
    $excuseSlips = ExcuseSlip::with('student', 'counselor', 'dean', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'read_by_teacher')
        ->whereHas('courseOfferings', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Approved by Dean', 'Rejected']);
        })
        ->get();

    // Parse date fields
    foreach ($excuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    // Query for all excuse slips with additional statuses
    $sort = request('sort', 'status'); // Get the sort value from the request, default to 'status'
    $allExcuseSlips = ExcuseSlip::with('student', 'counselor', 'dean', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'read_by_teacher')
        ->whereHas('courseOfferings', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Pending', 'Approved by Teacher', 'Rejected', 'Approved by Dean']);
        });

    // Sorting logic
    if ($sort == 'date') {
        $allExcuseSlips->orderBy('start_date', 'asc');
    } else {
        $allExcuseSlips->orderBy('status_id', 'asc');
    }

    $allExcuseSlips = $allExcuseSlips->get();

    // Parse date fields for all excuse slips
    foreach ($allExcuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    // Query for unread excuse slips (if needed)
    $unreadExcuseSlips = $excuseSlips;

    return view('teacher.dashboard', [
        'excuseSlips' => $excuseSlips,
        'allExcuseSlips' => $allExcuseSlips,
        'unreadExcuseSlips' => $unreadExcuseSlips,
        'sort' => $sort // Pass the sort variable to the view
    ]);
}
   

public function teacherStoreFeedback(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'feedback_remarks' => 'required|string|max:255',
    ]);

    // Find the excuse slip by ID
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Check if the authenticated user is a teacher and associated with the excuse slip
    if (auth()->user()->role_id == 2 && auth()->user()->teacher->teacher_id === $excuseSlip->teacher_id) {
        // Get the associated course offering
        $courseOffering = $excuseSlip->courseOfferings()->first(); // Assuming there's a relationship
        
        if ($courseOffering) {
            // Store the feedback in the course_excuse_slip pivot table
            DB::table('course_excuse_slip')->updateOrInsert(
                [
                    'excuse_slip_id' => $id,
                    'offer_code' => $courseOffering->offer_code,
                ],
                [
                    'is_remark_by_teacher' => true,
                    'teacher_feedback' => $request->input('feedback_remarks'),
                ]
            );

            // Redirect back with success message
            return redirect()->back()->with('success', 'Teacher Feedback submitted successfully.');
        } else {
            // Handle case when no course offering is found
            return redirect()->back()->withErrors('No associated course offering found.');
        }
    } else {
        // Unauthorized action, redirect with an error message
        abort(403, 'Unauthorized action.');
    }
}

public function markAsReadbyTeacher($excuseSlipId)
{
    $excuseSlip = ExcuseSlip::find($excuseSlipId);
    if ($excuseSlip) {
        $excuseSlip->read_by_teacher = true;
        $excuseSlip->save();
    }

    return redirect()->back();
}
}