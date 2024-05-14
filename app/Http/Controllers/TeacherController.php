<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
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
    $teacherId = $request->user()->teacher->teacher_id;

    $excuseSlip = ExcuseSlip::where('teacher_id', $teacherId)->findOrFail($excuseSlipId);
    $excuseSlip->status_id = 5; // Assuming status_id 5 represents the "signed" status
    $excuseSlip->save();

    // Notify the student associated with the excuse slip
    $studentEmail = $excuseSlip->student->email;
    if ($studentEmail) {
        Notification::route('mail', $studentEmail)
            ->notify(new ExcuseSlipSignedNotification($excuseSlip));
    }


    return redirect()->route('teacher.dashboard')->with('success', 'Excuse slip approved successfully.');
}

   

    
public function dashboard()
{
    $teacherId = auth()->user()->teacher->teacher_id;

    // Query for excuse slips with status "Approved by Dean" or "Rejected"
    $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'teacher_id', 'start_date', 'offer_code', 'end_date', 'status_id', 'read_by_teacher')
        ->where('teacher_id', $teacherId)
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Approved by Dean', 'Rejected']);
        })
        ->get();

    foreach ($excuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    // Query for excuse slips with status "Pending" or "Approved by Teacher" or "Rejected" or "Approved by Dean"
    $sort = request('sort', 'status'); // Get the sort value from the request, default to 'status'
    $allExcuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'teacher_id', 'start_date', 'offer_code', 'end_date', 'status_id', 'read_by_teacher')
        ->where('teacher_id', $teacherId)
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Pending', 'Approved by Teacher', 'Rejected', 'Approved by Dean']);
        });

    if ($sort == 'date') {
        $allExcuseSlips->orderBy('start_date', 'asc');
    } else {
        $allExcuseSlips->orderBy('status_id', 'asc');
    }

    $allExcuseSlips = $allExcuseSlips->get();

    foreach ($allExcuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    // Query for unread excuse slips
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
        // Store the feedback in the database
        $excuseSlip->teacherFeedbacks()->create([
            'remarks' => $request->input('feedback_remarks'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Teacher Feedback submitted successfully.');
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