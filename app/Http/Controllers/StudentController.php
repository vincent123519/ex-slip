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
    $studentId = auth()->user()->student->student_id;

    // Base query with relationships
    $query = ExcuseSlip::with('student', 'counselor', 'dean', 'courseOfferings.semester', 'status')
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'dean_id', 'start_date', 'end_date', 'status_id', 'created_at')
        ->where('student_id', $studentId);

    // Get filter inputs
    $sortBy = $request->input('sort_by', 'day');
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
    $excuseSlips = $query->paginate(10);

    // Unread slips (filtered from the paginated set)
    $unreadExcuseSlips = $excuseSlips->filter(fn($slip) => !$slip->is_read);

    // Teacher feedback slips (if you have this method)
    $feedbackexcuseSlips = $this->getExcuseSlipsWithTeacherFeedback($studentId);

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