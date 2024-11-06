<?php

namespace App\Http\Controllers;
use App\Notifications\ExcuseSlipCreatedNotification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Dean;
use App\Models\User; 
use App\Models\Course;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Counselor; 
use App\Models\ExcuseSlip;
use App\Models\Department; 
use App\Models\ExcuseStatus;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use App\Models\DepartmentDegree;
use App\Models\SupportingDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as AppNotification;


class ExcuseSlipController extends Controller
{
    // public function index()
    // {
    //     $excuseSlips = ExcuseSlip::with('student', 'teacher', 'counselor', 'dean', 'course', 'status')->get();
    //     return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    // }

    // public function index()
    // {
    //     // $studentId = auth()->user()->student->student_id;

    //     // Retrieve only the excuse slips for the logged-in student
    //     $excuseSlips = ExcuseSlip::select('start_date', 'end_date', 'status_id')->get();

    //     return view('excuseslip.index', ['excuseSlips' => $excuseSlips]);
    // }

    public function show($excuse_slip_id)
    {
        $excuseSlip = ExcuseSlip::with(['supportingDocuments', 'counselorFeedbacks', 'deanFeedbacks', 'teacherFeedbacks'])->findOrFail($excuse_slip_id);
    
        // Fetch counselor feedback for the excuse slip
        $counselorFeedback = $excuseSlip->counselorFeedbacks->first();
    
        // Fetch dean feedback for the excuse slip
        $deanFeedback = $excuseSlip->deanFeedbacks->first();
    
        // Fetch teacher feedback for the excuse slip
        $teacherFeedback = $excuseSlip->teacherFeedbacks->first();
    
        return view('excuseslip.show', compact('excuseSlip', 'counselorFeedback', 'deanFeedback', 'teacherFeedback'));
    }
    
    

    


    public function studentExcuseSlipList()
    {
        // $studentId = auth()->user()->student->student_id;

        // Retrieve only the excuse slips for the logged-in student
        $excuseSlips = ExcuseSlip::select('start_date', 'end_date', 'status_id')->get();
  


        return view ('student.dashboard', ['excuseSlips' => $excuseSlips]);
    }

    public function createExcuseSlip(Request $request)
    {
        $student = auth()->user()->student;
    
        // Fetch all study loads of the student
        $studyLoads = $student->studyLoads;
    
        // Initialize an empty array to hold all selected course offerings
        $selectedCourseOfferings = [];
    
        // Loop through each study load to collect course offerings
        foreach ($studyLoads as $studyLoad) {
            // Collect all course offerings for this study load
            $courseOfferings = $studyLoad->courseOfferings;
    
            // Add course offerings to the selected course offerings array
            foreach ($courseOfferings as $courseOffering) {
                // Create an array containing course offering and teacher details
                $selectedCourseOfferings[] = [
                    'course_offering_id' => $courseOffering->id,
                    'offer_code' => $courseOffering->offer_code,
                    'course_name' => $courseOffering->course->course_name,
                    'teacher_id' => $courseOffering->teacher->id,
                    'teacher_name' => $courseOffering->teacher->first_name,
                ];
            }
        }
    
        // Fetch other necessary data
        $degree = $student->degree;
        $department = $degree->department;
        $school = School::where('school_code', $department->school_code)->first();
        $dean = $school->dean;
        $counselor = $department->counselor;
        $excuseStatuses = ExcuseStatus::all();
        $yearLevel = $student->year_level;
        $coursesData = Course::select('course_code', 'course_name')->get();
        $teacherData = Teacher::select('teacher_id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))->get();
        $deanData = Dean::select('dean_id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))->get();
        $counselorData = Counselor::select('counselor_id', 'first_name', 'last_name')->get();
        $excuseSlip = new ExcuseSlip();
    
        return view('excuseslip.create', compact('selectedCourseOfferings', 'student', 'degree', 'department', 'school', 'dean', 'counselor', 'excuseStatuses', 'yearLevel', 'coursesData', 'teacherData', 'deanData', 'counselorData', 'excuseSlip'));
    }


    public function store(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'student_id' => 'required|exists:students,student_id',
        'counselor_id' => 'required|exists:counselors,counselor_id',
        'dean_id' => 'required|exists:deans,dean_id',
        'offer_codes' => 'required|array',
        'offer_codes.*' => 'required|string|exists:course_offerings,offer_code',
        'reason' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'supporting_documents.*' => 'nullable|mimetypes:application/pdf,application/pdfx',
    ]);

    $validatedData['status_id'] = 1;

    // Create the excuse slip only once
    $excuseSlip = ExcuseSlip::create([
        'student_id' => $validatedData['student_id'],
        'counselor_id' => $validatedData['counselor_id'],
        'dean_id' => $validatedData['dean_id'],
        'reason' => $validatedData['reason'],
        'start_date' => $validatedData['start_date'],
        'end_date' => $validatedData['end_date'],
        'status_id' => $validatedData['status_id'],
    ]);

    foreach ($validatedData['offer_codes'] as $offerCode) {
        $courseOffering = CourseOffering::where('offer_code', $offerCode)->first();
        \Log::info("Searching for CourseOffering with offer code: {$offerCode}");
    
        if ($courseOffering) {
            \Log::info("Found CourseOffering: ID = {$courseOffering->id}, Offer Code = {$courseOffering->offer_code}");
    
            $excuseSlip->courseOfferings()->attach($courseOffering->offer_code); // Use the offer code if it's a string
        } else {
            \Log::warning("CourseOffering not found for offer code: {$offerCode}");
        }
    }

    // Handle supporting documents
    if ($request->hasFile('supporting_documents')) {
        foreach ($request->file('supporting_documents') as $file) {
            $path = $file->store('supporting_documents', 'public');
            $document = new SupportingDocument([
                'document_path' => $path,
                'upload_date' => now(),
            ]);
            // Associate the document with the same excuse slip
            $excuseSlip->supportingDocuments()->save($document);
        }
    }

    // Send notification to the counselor
    $counselor = Counselor::find($validatedData['counselor_id']);
    // if ($counselor && $counselor->email) {
    //     Notification::route('mail', $counselor->email)
    //         ->notify(new ExcuseSlipCreatedNotification($excuseSlip));
    // }

    // Redirect with success message
    return redirect()->route('student.dashboard')->with('success', 'Excuse slips created successfully.');
}


    public function edit($id)
    {
        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);
    
        // Check if $excuseSlip is not null before proceeding
        if (!$excuseSlip) {
            // Handle the case where $excuseSlip is not found
            // For example, redirect to an error page or return an error response
        }
    
        // Retrieve other necessary data for editing the excuse slip
    
        // Return the edit excuse slip form view with the retrieved data
        return view('excuseslip.edit', [
            'excuseSlip' => $excuseSlip,
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'courses' => Course::all(),
            'counselors' => Counselor::all(),
            // Add other necessary data
        ]);
    }
    
    
    
    public function update(Request $request, $id)
    {
        // Validate the request data

        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);

        // Update the excuse slip with the new data
        $excuseSlip->student_id = $request->input('student_id');
        $excuseSlip->teacher_id = $request->input('teacher_id');
        $excuseSlip->counselor_id = $request->input('counselor_id');
        $excuseSlip->dean_id = $request->input('dean_id');
        $excuseSlip->course_code = $request->input('course_code');
        $excuseSlip->reason = $request->input('reason');
        $excuseSlip->start_date = $request->input('start_date');
        $excuseSlip->end_date = $request->input('end_date');
        $excuseSlip->status_id = $request->input('status_id');

        // Save the updated excuse slip to the database
        $excuseSlip->save();

        // Redirect the user to the excuse slip details page
        return redirect()->route('excuse_slips.show', ['id' => $excuseSlip->id]);
    }

    public function destroy($id)
    {
        // Retrieve the excuse slip with the given ID from the database
        $excuseSlip = ExcuseSlip::find($id);

        // Delete the excuse slip from the database
        $excuseSlip->delete();

        // Redirect the user to the excuse slips list page
        return redirect()->route('excuse_slips.index');
    }

    public function export(Request $request)
    {
        // Debug: Check received sorting criteria
        $sort_by = $request->input('sort_by');
        $month = $request->input('month');
        $year = $request->input('year');
        $semesterId = $request->input('semester_id'); // Add this line
        
        Log::info("Sort By: $sort_by, Month: $month, Year: $year, Semester ID: $semesterId"); // Add $semesterId to the log
    
        // Initialize query builder
        $excuseSlipsQuery = ExcuseSlip::query();
    
        // Apply sorting criteria
        switch ($sort_by) {
            case 'today':
                $excuseSlipsQuery->whereDate('created_at', today());
                break;
            case 'weekly':
                $excuseSlipsQuery->whereDate('created_at', '>=', today()->subDays(7));
                break;
            case 'month':
                $excuseSlipsQuery->whereYear('created_at', $year)
                                 ->whereMonth('created_at', $month);
                break;
            case 'year':
                $excuseSlipsQuery->whereYear('created_at', $year);
                break;
            case 'semester': // Add this case
                $excuseSlipsQuery->whereHas('course', function ($subquery) use ($semesterId) {
                    $subquery->where('semester_id', $semesterId);
                });
                break;
            default:
                // No sorting criteria selected, fetch all data
                break;
        }
    
        // Fetch the sorted data
        $excuseSlips = $excuseSlipsQuery->get();
    
        // Get the total count of excuse slips
        $totalExcuseSlips = $excuseSlips->count();
    
        // Define CSV file headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="excuse_slips.csv"',
        ];
    
        // Create and return the CSV response
        return response()->stream(function () use ($excuseSlips, $totalExcuseSlips) {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, ['Date', 'Student Name', 'Reason', 'Duration', 'Status']);
    
            // Add data rows
            foreach ($excuseSlips as $excuseSlip) {
                fputcsv($handle, [
                    $excuseSlip->created_at->format('Y-m-d'),
                    $excuseSlip->student->first_name . ' ' . $excuseSlip->student->last_name,
                    $excuseSlip->reason,
                    $excuseSlip->start_date . ' to ' . $excuseSlip->end_date,
                    $excuseSlip->status->status_name == 'Approved by Counselor' ? 'Approved' : $excuseSlip->status->status_name
                ]);
            }
    
            // Add two empty rows
            fputcsv($handle, []);
            fputcsv($handle, []);
    
            // Add total count row
            fputcsv($handle, ['Total Excuse Slips:', $totalExcuseSlips]);
    
            fclose($handle);
        }, 200, $headers);
    }
    
    
    


}   
