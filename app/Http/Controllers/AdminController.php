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
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use App\Models\DepartmentDegree;
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
            'file' => 'required|mimes:csv,txt|max:2048' // Adjust allowed file types and size as needed
        ]);

        $file = $request->file('file');

        try {
            $data = array_map('str_getcsv', file($file));

            foreach ($data as $row) {
                // Create a user with a username and set a default password
                $user = User::create([
                    'first_name' => $row[0], // Assuming the first column is the first name
                    'last_name' => $row[1], // Assuming the second column is the last name
                    'username' => $row[3], // Assuming the fourth column is the username
                    'password' => Hash::make('12345'), // You can set a default password
                    'role_id' => 3, // Replace 3 with the actual role ID for students
                ]);

                // Find the department degree
                $degree = DepartmentDegree::where('degree_name', $row[2])->first(); // Assuming the third column is the degree name

                if ($degree) {
                    $student = new Student([
                        'first_name' => $row[0],
                        'last_name' => $row[1],
                        'year_level' => $row[4], // Assuming the fifth column is the year level
                    ]);

                    $student->user()->associate($user);
                    $student->degree()->associate($degree);
                    $student->save();
                } else {
                    return redirect()->back()->with('error', 'Department degree not found for student: ' . $row[0]);
                }
            }

            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while importing students.');
        }
    }

    public function showImportForm()
    {
        return view('admin.import.import_students');
    }

    public function importTeachers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048' // Adjust allowed file types and size as needed
        ]);

        $file = $request->file('file');

        try {
            $data = array_map('str_getcsv', file($file));

            foreach ($data as $row) {
                // Create a user with a username and set a default password
                $user = User::create([
                    'first_name' => $row[0], // First Name
                    'last_name' => $row[1], // Last Name
                    'username' => $row[2], // Username
                    'password' => Hash::make('12345'), // Default Password
                    'role_id' => 2, // Teacher Role ID
                ]);

                // Find the department
                $department = Department::where('department_name', $row[3])->first(); // Department Name

                if ($department) {
                    $teacher = new Teacher([
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        // Add other teacher attributes if needed
                    ]);

                    $teacher->user()->associate($user);
                    $teacher->department()->associate($department);
                    $teacher->save();
                } else {
                    return redirect()->back()->with('error', 'Department not found for teacher: ' . $row[0]);
                }
            }

            return redirect()->back()->with('success', 'Teachers imported successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while importing teachers.');
        }
    }

    public function importCourses(Request $request)
{
    // Validate the uploaded CSV file
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048', // Adjust the file size limit as needed
    ]);

    // Get the file from the request
    $file = $request->file('file');

    // Read the CSV file and process each course
    $csvData = array_map('str_getcsv', file($file));
    $headers = array_shift($csvData); // Remove headers from CSV data

    foreach ($csvData as $row) {
        $courseData = [
            'course_code' => $row[0],
            'course_name' => $row[1],
            'department_id' => $row[2],
        ];

        // Check if the course already exists
        $existingCourse = Course::where('course_code', $courseData['course_code'])->first();

        if (!$existingCourse) {
            $course = Course::create($courseData);

            // Retrieve the department for the course
            $department = Department::find($courseData['department_id']);

            // Associate the course with the department
            $course->department()->associate($department);
            $course->save();
        }
    }

    return redirect()->route('courses.index')->with('success', 'Courses imported successfully.');
}

    

}
