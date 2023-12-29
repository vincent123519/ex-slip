<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;

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
        $excuseSlip->status_id = 4; // Assuming status_id 2 represents the "signed" status
        $excuseSlip->save();

        return redirect()->route('excuse_slips.index')->with('success', 'Excuse slip signed successfully.');
    }
    public function dashboard()
    {
        $teacherId = auth()->user()->teacher->teacher_id;
        $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course','status')
        ->select( 'excuse_slip_id','counselor_id', 'student_id' , 'reason', 'dean_id', 'teacher_id','start_date', 'course_code' ,'end_date', 'status_id')
        ->where('teacher_id', $teacherId)
        ->whereHas('status', function ($query) {
            $query->where('status_name', 'Approved by Dean');
        })
        ->get();

        foreach ($excuseSlips as $excuseSlip) {
            $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
            $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
        }
        return view('teacher.dashboard', ['excuseSlips' => $excuseSlips]);
    }

    public function delete($id)
    {
        // Find the excuse slip
        $excuseSlip = ExcuseSlip::find($id);

        // Check if the excuse slip exists
        if (!$excuseSlip) {
            return redirect()->back()->with('error', 'Excuse slip not found.');
        }

        // Perform the delete operation
        $excuseSlip->delete();

        // Redirect or perform other actions as needed
        return redirect()->back()->with('success', 'Excuse slip deleted successfully.');
    }   
}