<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Dean;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Counselor;
use App\Models\ExcuseSlip;
use App\Models\ExcuseStatus;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
    
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Show the create student form
        return view('student.create');
    }
    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'degree_id' => 'required',
            'year_level' => 'required',
        ]);

        // Create the student
        $student = Student::create($validatedData);

        // Redirect to the student's detail page
        return redirect()->route('students.show', $student->id)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'degree_id' => 'required',
            'year_level' => 'required',
        ]);

        // Find the student
        $student = Student::findOrFail($id);

        // Update the student
        $student->update($validatedData);

        // Redirect to the student's detail page
        return redirect()->route('students.show', $student->id)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the student
        $student = Student::findOrFail($id);

        // Delete the student
        $student->delete();

        // Redirect to the students' list
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

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
            'course_code' => 'required',
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
            'course_code' => 'required',
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
    // Retrieve excuse slips with status for the current user
    $studentId = auth()->user()->student->student_id;

    // Query for fetching excuse slips
    $query = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')
        ->where('student_id', $studentId)
        ->select('excuse_slip_id', 'counselor_id', 'student_id', 'dean_id', 'teacher_id', 'start_date', 'course_code', 'end_date', 'status_id', 'created_at');

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
            $year = $request->input('year', date('Y')); // Default to current year
            $query->whereYear('created_at', $year);
            break;
        default:
            // For 'day' or invalid inputs, no additional filtering needed
            break;
    }

    $excuseSlips = $query->get();

    // Format the created_at field in each ExcuseSlip to exclude hours, minutes, and seconds
    foreach ($excuseSlips as $excuseSlip) {
        $excuseSlip->formatted_created_at = $excuseSlip->created_at->format('Y-m-d'); // Exclude hours, minutes, and seconds
    }

    return view('student.dashboard', compact('excuseSlips'));
}

}