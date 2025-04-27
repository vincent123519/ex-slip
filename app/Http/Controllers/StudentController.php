<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Dean;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Counselor;
use App\Models\StudyLoad;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new excuse slip.
     *
     * @return \Illuminate\Http\Response
     */
    public function createExcuseSlip()
    {
        // Retrieve the necessary data for the form
        $courses = Course::all();
        $teachers = Teacher::all();
        $counselors = Counselor::all();
        $deans = Dean::all();
        $excuseStatuses = ExcuseStatus::all();

        return view('excuse_slips.create', compact('courses', 'teachers', 'counselors', 'deans', 'excuseStatuses'));
    }

    /**
     * Store a newly created excuse slip request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExcuseSlip(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'student_id' => 'required',
            'teacher_id' => 'required',
            'counselor_id' => 'required',
            'dean_id' => 'required',
            'offer_code' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status_id' => 'required',
        ]);

        // Create the excuse slip request
        $excuseSlip = ExcuseSlip::create($validatedData);

        // Redirect to the excuse slip detail page
        return redirect()->route('excuse_slips.show', $excuseSlip->id)
            ->with('success', 'Excuse slip request created successfully.');
    }

    /**
     * Show the form for submitting an excuse slip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submitExcuseSlip($id)
    {
        $excuseSlip = ExcuseSlip::findOrFail($id);

        return view('excuse_slips.submit', compact('excuseSlip'));
    }

    /**
     * Update the specified excuse slip request in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateExcuseSlip(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'student_id' => 'required',
            'teacher_id' => 'required',
            'counselor_id' => 'required',
            'dean_id' => 'required',
            'offer_code' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status_id' => 'required',
        ]);

        // Find the excuse slip request
        $excuseSlip = ExcuseSlip::findOrFail($id);

        // Update the excuse slip request
        $excuseSlip->update($validatedData);

        // Redirect to the excuse slip detail page
        return redirect()->route('excuse_slips.show', $excuseSlip->id)
            ->with('success', 'Excuse slip request updated successfully.');
    }
// Example in StudentController

public function dashboard(Request $request)
{
    // Retrieve the student ID of the currently authenticated user
    $studentId = auth()->user()->student->student_id;

    // Query for fetching excuse slips through the pivot table
    $query = ExcuseSlip::with(['student', 'counselor', 'dean', 'status', 'courseOfferings'])
        ->where('student_id', $studentId)
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'dean_id', 'start_date', 'end_date', 'status_id', 'created_at');

    // Sorting logic based on the request parameter
    $sort_by = $request->input('sort_by', 'day');

    switch ($sort_by) {
        case 'today':
            $query->whereDate('created_at', today());
            break;
        case 'month':
            // Filter by the selected year and month
            $year = $request->input('year', date('Y'));
            $month = $request->input('month', date('m'));
            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            break;
        case 'year':
            // Filter by the selected year
            $year = $request->input('year', date('Y')); // Default to the current year
            $query->whereYear('created_at', $year);
            break;
        default:
            // For 'day' or invalid inputs, no additional filtering needed
            break;
    }

    // Paginate the results
    $feedbackexcuseSlips = $this->getExcuseSlipsWithTeacherFeedback($studentId);

    $excuseSlips = $query->paginate(10); // Adjust the number of items per page as needed

    // Format the created_at field in each ExcuseSlip to exclude hours, minutes, and seconds
    $excuseSlips->each(function ($excuseSlip) {
        $excuseSlip->formatted_created_at = $excuseSlip->created_at->format('Y-m-d'); // Exclude hours, minutes, and seconds
    });

    // Get unread excuse slips (you may need to adjust this logic based on your criteria for "unread")
    $unreadExcuseSlips = $excuseSlips->filter(function ($excuseSlip) {
        return !$excuseSlip->is_read; // Assuming there is an 'is_read' field to check
    });

    return view('student.dashboard', compact('excuseSlips', 'unreadExcuseSlips', 'feedbackexcuseSlips'));
}

public function getExcuseSlipsWithTeacherFeedback($studentId)
{
    // Get all the study loads for a student and eager load the course offerings
    $studyLoads = StudyLoad::with('courseOfferings') // Eager load courseOfferings
        ->where('student_id', $studentId) // Filter by student ID
        ->get();

    // Collect all the excuse slips with teacher feedback
    $excuseSlips = collect();

    // Loop through study loads and course offerings
    foreach ($studyLoads as $studyLoad) {
        foreach ($studyLoad->courseOfferings as $courseOffering) {
            // Query the course_excuse_slip table to check if there is teacher feedback for the course offering
            $courseExcuseSlip = DB::table('course_excuse_slip')
                ->where('excuse_slip_id', $courseOffering->excuse_slip_id)
                ->where('offer_code', $courseOffering->offer_code)
                ->where('is_remark_by_teacher', 1) // Check if the teacher made a remark
                ->whereNotNull('teacher_feedback') // Ensure there's actual feedback
                ->first(); // Retrieve the first matching record

            // If there is teacher feedback, add this excuse slip to the collection
            if ($courseExcuseSlip) {
                $excuseSlips->push($courseOffering->courseExcuseSlips); // Add the related excuse slips to the collection
            }
        }
    }

    // Return unique excuse slips to avoid duplicates
    return $excuseSlips->unique('excuse_slip_id');
}



}