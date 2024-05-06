<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Dean;
use App\Models\User;
use App\Models\Course;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use App\Models\Counselor;
use App\Models\StudyLoad;
use App\Models\Department;
use App\Models\ExcuseSlip;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use App\Models\DepartmentDegree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    // Manually delete related records in the students table
    $user->student()->delete();

    // Delete the user
    $user->delete();

    return redirect()->route('manage-users')->with('success', 'User deleted successfully');
}
    public function showStudents()
{
    $students = Student::all();

    return view('admin.students.index', compact('students'));
}

public function showExcuseSlip(Request $request)
{
    $excuseslips = ExcuseSlip::query();

    // Apply filters
    if ($request->has('school_code')) {
        $schoolId = $request->input('school_code');
        $excuseslips->whereHas('student.degree.department.school', function ($query) use ($schoolId) {
            $query->where('school_code', $schoolId);
        });
    }

    if ($request->has('department_id')) {
        $departmentId = $request->input('department_id');
        $excuseslips->whereHas('student.degree.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        });
    }

    $excuseslips = $excuseslips->get();

    // Fetch all schools and departments for the dropdowns
    $schools = School::all();
    $departments = Department::all();

    return view('admin.excuseslips.index', compact('excuseslips', 'schools', 'departments'));
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

    return view('admin.studyload.create', [
        'studentId' => $studentId,
        'semesters' => $semesters,
        'courseCodes' => $courseCodes,
        'offerCodes' => $offerCodes,
    ]);
}

public function storeStudyLoad(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'student_id' => 'required|exists:students,student_id',
        'semester_id' => 'required|exists:semesters,semester_id',
        'offer_codes' => 'required|array',
        'offer_codes.*' => 'required|exists:course_offerings,offer_code',
    ]);

    // Retrieve the study load for the student and semester, or create a new one if it doesn't exist
    $studyLoad = StudyLoad::firstOrNew([
        'student_id' => $validatedData['student_id'],
        'semester_id' => $validatedData['semester_id'],
    ]);

    if (!$studyLoad->exists) {
        $studyLoad->save();
    }

    // Attach the offer codes to the study load
    $studyLoad->courseOfferings()->attach($validatedData['offer_codes']);

    // Redirect or return a response as needed
    return redirect()->route('admin.students.index')->with('success', 'Study load added successfully');
}
    

public function dashboard()
            {
         $data = [
        'total_students' => Student::count(),
        'total_teachers' => Teacher::count(),
        'total_deans' => Dean::count(),
        'total_counselors' => Counselor::count(),
        'total_excuse' => ExcuseSlip::count(),

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
                    'email' => $row[5],
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
                        'email' => $row[5],
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
                    'email' => $row[4],

                ]);

                // Find the department
                $department = Department::where('department_name', $row[3])->first(); // Department Name

                if ($department) {
                    $teacher = new Teacher([
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        // Add other teacher attributes if needed
                        'email' => $user->email,

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
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048' // Adjust allowed file types and size as needed
    ]);

    try {
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $row) {
            // Ensure that the row has the correct number of columns
            if (count($row) < 3) {
                Log::error('Invalid row format: ' . implode(',', $row));
                continue; // Skip invalid rows
            }

            // Extract data from the row
            $courseCode = $row[0];
            $courseName = $row[1];
            $departmentId = (int) $row[2]; // Ensure department ID is an integer

            // Create the course
            $course = new Course();
            $course->course_code = $courseCode;
            $course->course_name = $courseName;
            $course->department_id = $departmentId;

            // Save the course
            $course->save();
        }

        return redirect()->back()->with('success', 'Courses imported successfully.');
    } catch (Exception $e) {
        Log::error('Error occurred while importing courses: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error occurred while importing courses.');
    }
}


    //
    public function importCourseOfferings(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048' // Adjust allowed file types and size as needed
    ]);

    try {
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $row) {
            // Ensure that the row has the correct number of columns
            if (count($row) < 7) {
                Log::error('Invalid row format: ' . implode(',', $row));
                continue; // Skip invalid rows
            }

            // Extract data from the row
            $offerCode = $row[0];
            $courseCode = $row[1];
            $semesterId = $row[2];
            $teacherId = $row[3];
            $startTime = $row[4];
            $endTime = $row[5];
            $daysOfWeek = $row[6];

            // Check if the course exists
            $course = Course::where('course_code', $courseCode)->first();
            if (!$course) {
                Log::error("Course with code '{$courseCode}' not found for offering with offer code '{$offerCode}'");
                continue; // Skip this row
            }

            // Check if the semester exists
            $semester = Semester::find($semesterId);
            if (!$semester) {
                Log::error("Semester with ID '{$semesterId}' not found for offering with offer code '{$offerCode}'");
                continue; // Skip this row
            }

            // Check if the teacher exists
            $teacher = Teacher::find($teacherId);
            if (!$teacher) {
                Log::error("Teacher with ID '{$teacherId}' not found for offering with offer code '{$offerCode}'");
                continue; // Skip this row
            }

            // Create the course offering
            CourseOffering::create([
                'offer_code' => $offerCode,
                'course_code' => $courseCode,
                'semester_id' => $semesterId,
                'teacher_id' => $teacherId,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'days_of_week' => $daysOfWeek,
            ]);
        }

        return redirect()->back()->with('success', 'Course offerings imported successfully.');
    } catch (\Exception $e) {
        Log::error('Error occurred while importing course offerings: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error occurred while importing course offerings.');
    }
}

public function uploadUserImages(Request $request)
{
    // Validation for csvfile
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');

    $csv = array_map('str_getcsv', file($file->path()));

    foreach ($csv as $row) {
        $userId = $row[0]; // Assuming user_id is in the first column
        $fileName = $row[1]; // Assuming image file name is in the second column

        // Find the user by id
        $user = User::find($userId);

        if ($user) {
            // Remove existing image if any
            if ($user->image) {
                Storage::disk('public')->delete('user_images/' . $user->image);
            }

            // Store the uploaded image as user image
            $file->storeAs('user_images', $fileName, 'public');

            // Update the user's image column
            $user->image = $fileName;
            $user->save();
        }
    }

    return redirect()->back()->with('success', 'CSV file uploaded successfully.');
}



public function importStudyLoad(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048' // Adjust allowed file types and size as needed
    ]);

    try {
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));

        // Remove the header row
        array_shift($data);

        // Process the remaining rows
        foreach ($data as $row) {
            // Validate the data format
            if (count($row) !== 3) {
                throw new \Exception("Invalid row format. Each row must contain student ID, semester ID, and offer code.");
            }

            // Extract data from the row
            $studentId = $row[0];
            $semesterId = $row[1];
            $offerCode = $row[2];

            // Validate the extracted data if needed

            // Create or update the study load record
            $studyLoad = StudyLoad::firstOrNew([
                'student_id' => $studentId,
                'semester_id' => $semesterId,
            ]);

            if (!$studyLoad->exists) {
                $studyLoad->save();
            }

            // Attach the offer code to the study load
            $studyLoad->courseOfferings()->attach($offerCode);
        }

        return redirect()->back()->with('success', 'Study load imported successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error occurred while importing study load: ' . $e->getMessage());
    }
}


public function editStudentDetails($id)
{
    $student = Student::findOrFail($id);
    $degrees = DepartmentDegree::all();


    return view('admin.students.edit-student-details', compact('student', 'degrees'));
}



public function updateStudentDetails(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'year_level' => 'required|integer|min:1|max:5',
        'degree_id' => 'required|exists:department_degrees,degree_id',
        'email' => 'required|email|max:255',
    ]);

    // Update student details
    $student->fill($validatedData);
    $student->save();

    return redirect()->route('admin.students.index')->with('success', 'Student details updated successfully.');
}

}