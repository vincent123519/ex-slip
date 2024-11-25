<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dean;
use App\Models\Feedback;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApprovedByDeanNotification;

class DeanController extends Controller
{
    /**
     * Display a listing of the excuse slip requests for the dean.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated dean
        $dean = auth()->user()->dean;

        // Get the excuse slip requests assigned to the dean
        $excuseSlips = ExcuseSlip::where('dean_id', $dean->dean_id)->get();

        return response()->json($excuseSlips);
    }

    /**
     * Approve an excuse slip request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveExcuseSlip(Request $request, $id)
{
    // Find the excuse slip by ID assigned to the 
    $excuseSlip = ExcuseSlip::where('dean_id', auth()->user()->dean->dean_id)
        ->findOrFail($id);

    // Update the excuse slip status to approved
    $excuseSlip->update(['status_id' => '4']);
    
    // Notify the teacher associated with the excuse slip
    // $teacherEmail = $excuseSlip->teacher->email;
    // if ($teacherEmail) {
    //     Notification::route('mail', $teacherEmail)
    //         ->notify(new ApprovedByDeanNotification($excuseSlip));
    // }

    // Return a success response
    return redirect()->route('dean.dashboard')->with('success', 'Excuse slip approved successfully.');
}

    

    /**
     * Reject an excuse slip request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectExcuseSlip(Request $request, $id)
    {
        // Find the excuse slip by ID assigned to the dean
        $excuseSlip = ExcuseSlip::where('dean_id', auth()->user()->dean->dean_id)
            ->findOrFail($id);

        // Update the excuse slip status to rejected
        $excuseSlip->update(['status_id' => '3']);

        // Return a success response
        return redirect()->route('dean.dashboard')->with('success', 'Excuse slip rejected successfully.');
    }

    /**
     * Add feedback or remarks to an excuse slip request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addFeedback(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'feedback_remarks' => 'required|string',
            'feedback_type' => 'required|string',
        ]);

        // Find the excuse slip by ID assigned to the dean
        $excuseSlip = ExcuseSlip::where('dean_id', auth()->user()->dean->dean_id)
            ->findOrFail($id);

        // Create a new feedback instance
        $feedback = new Feedback([
            'feedback_remarks' => $request->input('feedback_remarks'),
            'feedback_date' => now(),
            'sender_id' => auth()->id(),
            'feedback_type' => $request->input('feedback_type'),
        ]);

        // Associate the feedback with the excuse slip
        $excuseSlip->feedback()->save($feedback);

        // Return a success response
        return response()->json(['message' => 'Feedback added successfully']);
    }
    
    public function dashboard()
{
    $deanId = auth()->user()->dean->dean_id;

    $excuseSlips = ExcuseSlip::with('student', 'counselor', 'dean', 'courses', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'read_by_dean','updated_at')
        ->where('dean_id', $deanId)
        ->whereHas('status', function ($query) {
            $query->whereIn('status_id', [2, 4, 3]);
        })
        ->orderByDesc('created_at')
        ->get();

    foreach ($excuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    $unreadExcuseSlips = $excuseSlips; 

    return view('dean.dashboard', ['excuseSlips' => $excuseSlips, 'unreadExcuseSlips' => $unreadExcuseSlips]);
}

    public function sendToTeacher($excuseSlipId, $teacherId)
    {
        // Find the excuse slip
        $excuseSlip = ExcuseSlip::find($excuseSlipId);
        $teacherId = $excuseSlip->teacher_id;

        // Check if the excuse slip exists
        if (!$excuseSlip) {
            // Handle not found case, maybe redirect back with an error message
            return redirect()->back()->with('error', 'Excuse slip not found.');
        }

        // Check if the teacher is assigned to the dean
        if ($excuseSlip->dean_id != auth()->user()->dean->dean_id || $excuseSlip->status->status_name != 'approved') {
            // Handle unauthorized or invalid state, maybe redirect back with an error message
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update the teacher_id
        $excuseSlip->teacher_id = $teacherId;
        $excuseSlip->save();

        // Redirect or perform other actions as needed
        return redirect()->back()->with('success', 'Excuse slip sent to the teacher.');
    }


    public function deanStoreFeedback(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'feedback_remarks' => 'required|string|max:255',
    ]);

    // Find the excuse slip by ID
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Check if the authenticated user is a dean and associated with the excuse slip
    if (auth()->user()->role_id == 5 && auth()->user()->dean->dean_id === $excuseSlip->dean_id) {
        // Store the feedback in the database
        $excuseSlip->deanFeedbacks()->create([
            'remarks' => $request->input('feedback_remarks'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Dean Feedback submitted successfully.');
    } else {
        // Unauthorized action, redirect with an error message
        abort(403, 'Unauthorized action.');
    }
}


public function deanNotification()
{
    $deanId = auth()->user()->dean->dean_id;

    // Query for fetching the latest unread excuse slip notifications for the dean
    $notificationQuery = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'teacher_id', 'start_date', 'offer_code', 'end_date', 'status_id', 'created_at', 'read_by_dean')
        ->where('dean_id', $deanId)
        ->where('read_by_dean', false) 
        ->orderByDesc('created_at')
        ->take(5)
        ->get();

    return $notificationQuery;

}

//mark as read
public function markAsReadbyDean($excuseSlipId)
{
    $excuseSlip = ExcuseSlip::find($excuseSlipId);
    if ($excuseSlip) {
        $excuseSlip->read_by_dean = true;
        $excuseSlip->save();
    }

    return redirect()->back();
}

}