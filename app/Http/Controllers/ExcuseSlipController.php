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

    public function createExcuseSlip()
{
    $student = auth()->user()->student;
    $studyLoads = $student->studyLoads;
    $selectedCourseOfferings = [];
    foreach ($studyLoads as $studyLoad) {
        $courseOfferings = $studyLoad->courseOfferings;
        foreach ($courseOfferings as $courseOffering) {
            $selectedCourseOfferings[] = [
                'course_offering_id' => $courseOffering->id,
                'offer_code' => $courseOffering->offer_code,
                'course_name' => $courseOffering->course->course_name,
                'teacher_id' => $courseOffering->teacher->id,
                'teacher_name' => $courseOffering->teacher->first_name,
            ];
        }
    }
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
    return view('excuseslip.create', compact('selectedCourseOfferings', 'student', 'degree', 'department', 'school', 'dean', 'counselor', 
    'excuseStatuses', 'yearLevel', 'coursesData', 'teacherData', 'deanData', 'counselorData', 'excuseSlip'));
}


public function store(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'student_id' => 'required',
        'counselor_id' => 'required',
        'dean_id' => 'required',
        'offer_codes' => 'required|array',
        'offer_codes.*' => 'required',
        'reason' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'supporting_document' => 'required|mimetypes:application/pdf,application/pdfx',
    ]);

    $validatedData['status_id'] = 1;
    $createdSlips = [];
    foreach ($validatedData['offer_codes'] as $offerCode) {
        $courseOffering = CourseOffering::where('offer_code', $offerCode)->first();

        if ($courseOffering) {
            $teacherId = $courseOffering->teacher_id;
            $courseOfferingId = $courseOffering->id;
            $excuseData = [
                'student_id' => $validatedData['student_id'],
                'counselor_id' => $validatedData['counselor_id'],
                'dean_id' => $validatedData['dean_id'],
                'teacher_id' => $teacherId,
                'course_offering_id' => $courseOfferingId,
                'offer_code' => $offerCode,
                'reason' => $validatedData['reason'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'status_id' => $validatedData['status_id'],
            ];
            $excuseSlip = ExcuseSlip::create($excuseData);
            $createdSlips[] = $excuseSlip;
            $counselor = User::find($validatedData['counselor_id']);
            Notification::send($counselor, new ExcuseSlipCreatedNotification($excuseSlip));
        }
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $path = $file->storeAs('supporting_documents', $file->getClientOriginalName(), 'public'); 
            $document = new SupportingDocument([
                'document_path' => $path,
                'upload_date' => now(),
            ]);
            $excuseSlip->supportingDocuments()->save($document);
        }
    }
    session()->flash('success', 'Excuse slip requests created successfully.');
    return redirect()->route('student.dashboard');
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
        $excuseSlip = ExcuseSlip::find($id);
        $excuseSlip->delete();
        return redirect()->route('excuse_slips.index');
    }

    public function export(Request $request)
    {
        // Debug: Check received sorting criteria
        $sort_by = $request->input('sort_by');
        $month = $request->input('month');
        $year = $request->input('year');
        Log::info("Sort By: $sort_by, Month: $month, Year: $year");
    
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
            default:
                // No sorting criteria selected, fetch all data
                break;
        }
        $excuseSlips = $excuseSlipsQuery->get();
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
    
    public function export(Request $request)
{
    $sort_by = $request->input('sort_by');
    $month = $request->input('month');
    $year = $request->input('year');

    $excuseSlipsQuery = ExcuseSlip::query();

    switch ($sort_by) {
        case 'today':
            $excuseSlipsQuery->whereDate('created_at', today());
            break;
        case 'weekly':
            $excuseSlipsQuery->whereDate('created_at', '>=', today()->subDays(7));
            break;
        case 'month':
            $excuseSlipsQuery->whereYearMonth('created_at', $year, $month);
            break;
        case 'year':
            $excuseSlipsQuery->whereYear('created_at', $year);
            break;
    }
    $excuseSlips = $excuseSlipsQuery->get();
    $totalExcuseSlips = $excuseSlips->count();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="excuse_slips.csv"',
    ];

    return response()->stream(function () use ($excuseSlips, $totalExcuseSlips) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Date', 'Student Name', 'Reason', 'Duration', 'Status']);

        foreach ($excuseSlips as $excuseSlip) {
            fputcsv($handle, [
                $excuseSlip->created_at->format('Y-m-d'),
                $excuseSlip->student->fullName(),
                $excuseSlip->reason,
                $excuseSlip->start_date . ' to ' . $excuseSlip->end_date,
                $excuseSlip->status->formattedStatus(),
            ]);
        }

        fputcsv($handle, ['', '']); // Adding empty rows
        fputcsv($handle, ['Total Excuse Slips:', $totalExcuseSlips]);

        fclose($handle);
    }, 200, $headers);
}

    


}   
