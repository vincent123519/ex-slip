<?php

namespace App\Http\Controllers;

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
        $excuseSlip->status_id = 2; // Assuming status_id 2 represents the "signed" status
        $excuseSlip->save();

        return redirect()->route('excuse_slips.index')->with('success', 'Excuse slip signed successfully.');
    }
}