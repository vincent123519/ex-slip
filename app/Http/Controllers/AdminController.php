<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Dean;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Counselor;
use App\Models\StudyLoad;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function bulkUploadStudents(Request $request)
    {
        // Upload and import student data
    }


    public function manageUsers(Request $request)
    {
        // Get all users
        $query = User::query();
    
        // Filter users by role if a role filter is provided
        if ($request->has('role_filter')) {
            $roleFilter = $request->input('role_filter');
    
            if ($roleFilter !== 'reset' && $roleFilter !== 'All') {
                $query->whereHas('role', function ($q) use ($roleFilter) {
                    $q->where('role_name', $roleFilter);
                });
            }
        }
    
        $users = $query->get();
    
        return view('admin.manage-users', compact('users'));
    }
    

    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }
    
    public function updateUser(User $user, Request $request)
    {
        $user->update($request->only(['name', 'email']));

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('manage-users')->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('manage-users')->with('success', 'User deleted successfully');
    }
    public function showStudents()
{
    $students = Student::all();

    return view('admin.students.index', compact('students'));
}

public function createStudyLoad($studentId)
    {
        // Retrieve the student from the database
        $student = Student::findOrFail($studentId);

        // Retrieve the semesters from the database
        $semesters = Semester::all();

        // Retrieve the course codes from the database
        $courseCodes = Course::all();

        // Retrieve the offer codes from the database
        $offerCodes = CourseOffering::all();


        return view('admin.studyload.create', ['studentId' => $studentId, 'semesters' => $semesters, 'courseCodes' => $courseCodes, 'offerCodes' => $offerCodes]);

    }

    public function storeStudyLoad(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'semester_id' => 'required',
            'offer_code' => 'required',
        ]);

        // Create a new study load instance
        $studyLoad = new StudyLoad();
        $studyLoad->student_id = $validatedData['student_id'];
        $studyLoad->semester_id = $request->input('semester_id');
        $studyLoad->offer_code = $request->input('offer_code');
        $studyLoad->save();

        // Redirect or return a response as needed
        return redirect()->route('admin.students.index')->with('success', 'Study load added successfully');    }

        public function dashboard()
            {
         $data = [
        'total_students' => Student::count(),
        'total_teachers' => Teacher::count(),
        'total_deans' => Dean::count(),
        'total_counselors' => Counselor::count(),
        // Add more data as needed
    ];

    return view('admin.dashboard', $data);
}

            
// for the teacher ni
public function showTeacher()
{
    $teachers = Teacher::with('department')->get();

    return view('admin.teachers.index', compact('teachers'));
}

public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048' 
        ]);

        $file = $request->file('file');

        $data = array_map('str_getcsv', file($file));
        foreach ($data as $row) {
            Student::create([
                'name' => $row[0], 
                'email' => $row[1],
            ]);
        }

        return redirect()->back()->with('success', 'Students imported successfully.');
    }

    public function showImportForm()
    {
        return view('admin.import.import_students');
    }

    public function importTeachers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048' 
        ]);

        $file = $request->file('file');
        
        try {
            $data = array_map('str_getcsv', file($file));
            
            foreach ($data as $row) {
                Teacher::create([
                    'name' => $row[0], 
                    'email' => $row[1], 
                ]);
            }

            return redirect()->back()->with('success', 'Teachers imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while importing teachers.');
        }
    }

    public function importCourses(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048' 
        ]);

        $file = $request->file('file');
        
        try {
            $data = array_map('str_getcsv', file($file));
            
            foreach ($data as $row) {
                Course::create([
                    'name' => $row[0], 
                    'description' => $row[1], 
                ]);
            }

            return redirect()->back()->with('success', 'Courses imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while importing courses.');
        }
    }

}
