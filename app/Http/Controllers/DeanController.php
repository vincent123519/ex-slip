<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dean;
use App\Models\Feedback;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;

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
        // Find the excuse slip by ID assigned to the dean
        $excuseSlip = ExcuseSlip::where('dean_id', auth()->user()->dean->dean_id)
            ->findOrFail($id);

        // Update the excuse slip status to approved
        $excuseSlip->update(['status_id' => 'approved']);

        // Return a success response
        return response()->json(['message' => 'Excuse slip approved successfully']);
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
        $excuseSlip->update(['status_id' => 'rejected']);

        // Return a success response
        return response()->json(['message' => 'Excuse slip rejected successfully']);
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

        $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course','status')
        ->select( 'excuse_slip_id','counselor_id', 'student_id' , 'reason', 'dean_id', 'teacher_id','start_date', 'course_code' ,'end_date', 'status_id')
        ->where('dean_id', $deanId)
        ->whereHas('status', function ($query) {
            $query->where('status_name', 'approved');
        })
        ->get();

        foreach ($excuseSlips as $excuseSlip) {
            $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
            $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
        }
        return view('dean.dashboard', ['excuseSlips' => $excuseSlips]);
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
}
