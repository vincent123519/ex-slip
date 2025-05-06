<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Semester;
use App\Models\ExcuseSlip;
use App\Models\SchoolYear;
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
public function dashboard(Request $request)
{
    $teacherId = auth()->user()->teacher->teacher_id;

    // Query for excuse slips associated with the teacher via the course_offerings table
    $excuseSlipsQuery = ExcuseSlip::with('student', 'counselor', 'dean', 'status', 'courseOfferings.semester')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'read_by_teacher')
        ->whereHas('courseOfferings', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Approved by Dean', 'Rejected']);
        });

    // Apply semester filter if provided
    if ($request->has('semester_id') && $request->input('semester_id') !== null) {
        $semesterId = $request->input('semester_id');
        $excuseSlipsQuery->whereHas('courseOfferings.semester', function ($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        });
    }

    // Apply school year filter if provided
    if ($request->has('school_year_id') && $request->input('school_year_id') !== null) {
        $schoolYearId = $request->input('school_year_id');
        $excuseSlipsQuery->whereHas('courseOfferings.semester', function ($query) use ($schoolYearId) {
            $query->where('sy_id', $schoolYearId);
        });
    }

    // Get the filtered list
    $excuseSlips = $excuseSlipsQuery->get();

    // Parse date fields
    foreach ($excuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);

        // Retrieve course offerings details with remarks
        $excuseSlip->offerCodesWithDetails = $excuseSlip->courseOfferings->map(function ($courseOffering) use ($excuseSlip) {
            $isRemarkByTeacher = DB::table('course_excuse_slip')
                ->where('excuse_slip_id', $excuseSlip->excuse_slip_id)
                ->where('offer_code', $courseOffering->offer_code)
                ->value('is_remark_by_teacher');

            return [
                'offer_code' => $courseOffering->offer_code,
                'course_code' => $courseOffering->course->course_code,
                'teacher_name' => $courseOffering->teacher->first_name . ' ' . $courseOffering->teacher->last_name,
                'is_remark_by_teacher' => $isRemarkByTeacher
            ];
        });
    }

    // Sorting preference
    $sort = $request->input('sort', 'status');

    // Query for all excuse slips with additional statuses
    $allExcuseSlipsQuery = ExcuseSlip::with('student', 'counselor', 'dean', 'status', 'courseOfferings.semester')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'read_by_teacher')
        ->whereHas('courseOfferings', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->whereHas('status', function ($query) {
            $query->whereIn('status_name', ['Pending', 'Approved by Teacher', 'Rejected', 'Approved by Dean']);
        });

    // Apply semester filter to allExcuseSlips if provided
    if ($request->has('semester_id') && $request->input('semester_id') !== null) {
        $semesterId = $request->input('semester_id');
        $allExcuseSlipsQuery->whereHas('courseOfferings.semester', function ($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        });
    }

    // Apply school year filter to allExcuseSlips if provided
    if ($request->has('school_year_id') && $request->input('school_year_id') !== null) {
        $schoolYearId = $request->input('school_year_id');
        $allExcuseSlipsQuery->whereHas('courseOfferings.semester', function ($query) use ($schoolYearId) {
            $query->where('sy_id', $schoolYearId);
        });
    }

    // Apply sorting
    if ($sort === 'date') {
        $allExcuseSlipsQuery->orderBy('start_date', 'asc');
    } else {
        $allExcuseSlipsQuery->orderBy('status_id', 'asc');
    }

    $allExcuseSlips = $allExcuseSlipsQuery->get();

    // Parse date fields
    foreach ($allExcuseSlips as $excuseSlip) {
        $excuseSlip->start_date = Carbon::parse($excuseSlip->start_date);
        $excuseSlip->end_date = Carbon::parse($excuseSlip->end_date);
    }

    // Check for remarks and update status if needed
    foreach ($allExcuseSlips as $excuseSlip) {
        $isApprovedByTeacher = true;

        foreach ($excuseSlip->courseOfferings as $courseOffering) {
            $isRemarkByTeacher = DB::table('course_excuse_slip')
                ->where('excuse_slip_id', $excuseSlip->excuse_slip_id)
                ->where('offer_code', $courseOffering->offer_code)
                ->value('is_remark_by_teacher');

            if (!$isRemarkByTeacher) {
                $isApprovedByTeacher = false;
                break;
            }
        }

        if ($isApprovedByTeacher) {
            $excuseSlip->status_id = 5; // Approved by Teacher
            $excuseSlip->save();
        }
    }

    $unreadExcuseSlips = $excuseSlips->where('read_by_teacher', false);

    // Fetch all semesters and school years for dropdowns
    $semesters = Semester::all();
    $schoolYears = SchoolYear::all();

    return view('teacher.dashboard', [
        'excuseSlips' => $excuseSlips,
        'allExcuseSlips' => $allExcuseSlips,
        'unreadExcuseSlips' => $unreadExcuseSlips,
        'sort' => $sort,
        'semesters' => $semesters,
        'schoolYears' => $schoolYears
    ]);
}



    public function teacherStoreFeedback(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'feedback_remarks' => 'required|string|max:255',
        'offer_code' => 'required|integer', // Ensure an offer_code is provided
    ]);

    // Find the excuse slip by ID
    $excuseSlip = ExcuseSlip::findOrFail($id);

    // Check if the authenticated user is a teacher
    if (auth()->user()->role_id == 2) { // Ensure user is a teacher
        // Get the authenticated teacher's ID
        $teacherId = auth()->user()->teacher->teacher_id;

        // Get the submitted offer_code from the request
        $submittedOfferCode = $request->input('offer_code');

        // Check if the teacher is associated with the given offer code
        $courseOffering = $excuseSlip->courseOfferings()
            ->where('course_offerings.offer_code', $submittedOfferCode) // Specify the table name
            ->where('course_offerings.teacher_id', $teacherId) // Specify the table name
            ->first();

        if ($courseOffering) {
            // Store the feedback in the course_excuse_slip table for the specific offer_code
            DB::table('course_excuse_slip')->updateOrInsert(
                [
                    'excuse_slip_id' => $id,
                    'offer_code' => $submittedOfferCode, // Use the specific offer_code from the form
                ],
                [
                    'is_remark_by_teacher' => 1, // Mark as feedback given (if needed)
                    'teacher_feedback' => $request->input('feedback_remarks'), // Store feedback
                ]
            );

            // Redirect back with success message
            return redirect()->back()->with('success', 'Teacher feedback submitted successfully for the offer code.');
        } else {
            // Handle case when no course offering is found for this teacher and offer code
            return redirect()->back()->withErrors('You are not authorized to provide feedback for this offer code.');
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