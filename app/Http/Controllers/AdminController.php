<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Dean;
use App\Models\User;
use App\Models\Course;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;
use App\Enums\DegreeEnum;
use App\Models\Counselor;
use App\Models\StudyLoad;
use App\Models\Department;
use App\Models\ExcuseSlip;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\CourseOffering;
use App\Models\DepartmentDegree;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{



    public function manageUsers(Request $request)
{
    $query = User::query();

    if ($request->has('role_filter')) {
        $roleFilter = $request->input('role_filter');

        if ($roleFilter !== 'reset' && $roleFilter !== 'All') {
            $query->whereHas('role', function ($q) use ($roleFilter) {
                $q->where('role_name', $roleFilter);
            });
        }
    }

    $users = $query->paginate(20); // <-- Here: paginate by 20

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
    $user->student()->delete();

    $user->delete();

    return redirect()->route('manage-users')->with('success', 'User deleted successfully');
}
    public function showStudents()
{
    $students = Student::all();

    return view('admin.students.index', compact('students'));
}

//promote teacher to dean
public function promote(Request $request, $deanId)
{
    // Validate that the teacher ID is provided
    $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
    ]);

    // Fetch the selected teacher
    $teacher = Teacher::findOrFail($request->input('teacher_id'));

    // Logic to promote the teacher to dean
    // For example, creating a new Dean record
    $dean = new Dean();
    $dean->first_name = $teacher->first_name;
    $dean->last_name = $teacher->last_name;
    $dean->email = $teacher->email; // or whatever logic you want to use
    $dean->user_id = $teacher->user_id;
    $dean->save();

    return redirect()->route('admin.dean.index')->with('success', 'Teacher promoted to Dean successfully!');
}

public function showExcuseSlip(Request $request)
{
    $excuseslips = ExcuseSlip::with('student.degree.department.school', 'courseOfferings.semester') // load relationships
                    ->select('excuse_slip_id', 'counselor_id', 'student_id', 'reason', 'dean_id', 'start_date', 'end_date', 'status_id', 'created_at');

    // Apply school filter
    if ($request->has('school_code') && $request->input('school_code') !== null) {
        $schoolId = $request->input('school_code');
        $excuseslips->whereHas('student.degree.department.school', function ($query) use ($schoolId) {
            $query->where('school_code', $schoolId);
        });
    }

    // Apply department filter
    if ($request->has('department_id') && $request->input('department_id') !== null) {
        $departmentId = $request->input('department_id');
        $excuseslips->whereHas('student.degree.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        });
    }

    // Apply semester filter
    if ($request->has('semester_id') && $request->input('semester_id') !== null) {
        $semesterId = $request->input('semester_id');
        $excuseslips->whereHas('courseOfferings', function ($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        });
    }

    // Apply school year filter
    if ($request->has('school_year_id') && $request->input('school_year_id') !== null) {
        $schoolYearId = $request->input('school_year_id');
        $excuseslips->whereHas('courseOfferings.semester', function ($query) use ($schoolYearId) {
            $query->where('sy_id', $schoolYearId);
        });
    }

    // Finally fetch the results (you can paginate if you want also)
    $excuseslips = $excuseslips->get();

    // Fetch all schools, departments, semesters, and school years for dropdowns
    $schools = School::all();
    $departments = Department::all();
    $semesters = Semester::all(); // Assuming you have Semester model
    $schoolYears = SchoolYear::all(); // Assuming you have SchoolYear model

    return view('admin.excuseslips.index', compact('excuseslips', 'schools', 'departments', 'semesters', 'schoolYears'));
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
        'pending_excuses' => ExcuseSlip::whereIn('status_id', [1, 2, 4])->count(),
        'approved_excuses' => ExcuseSlip::where('status_id', 5)->count(),
        'rejected_excuses' => ExcuseSlip::where('status_id', 3)->count(),
        'total_schools' => School::count(),
        'total_departments' => Department::count(),
        'total_degree' => DepartmentDegree::count(),


        // Add more data as needed
    ];

    return view('admin.dashboard', $data);
}

public function schools()
{
    // Fetch all schools and teachers
    $schools = School::all();
    $teachers = Teacher::all();  // Fetch all teachers

    // Return the view with schools and teachers data
    return view('admin.schools.index', [
        'schools' => $schools,
        'teachers' => $teachers,  // Pass teachers to the view
    ]);
}

    
public function storeSchool(Request $request)
{
    $validator = Validator::make($request->all(), [
        'school_code' => 'required|integer|unique:schools,school_code',
        'school_name' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create the school
    $school = School::create([
        'school_code' => $request->school_code,
        'school_name' => $request->school_name,
    ]);

    // Create the default dean details
    $defaultDeanFirstName = 'Default';
    $defaultDeanLastName = 'Dean';
    $defaultDeanUsername = strtolower($request->school_name . '.dean');

    // Create a new User for the Dean role
    $user = User::create([
        'first_name' => $defaultDeanFirstName,
        'last_name' => $defaultDeanLastName,
        'username' => $defaultDeanUsername,
        'password' => Hash::make('12345'), // Default password
        'role_id' => 5, // Dean role
    ]);

    // Create and associate the Dean
    $dean = new Dean([
        'first_name' => $defaultDeanFirstName,
        'last_name' => $defaultDeanLastName,
    ]);

    $dean->user()->associate($user);
    $dean->school()->associate($school);
    $dean->save();

    return view('admin.schools.index', [
        'schools' => School::all(),
    ])->with('success', 'School added and default dean assigned successfully!');
    
}






    public function editSchool($school_code)
    {
        $school = School::where('school_code', $school_code)->firstOrFail();
        return view('admin.schools.edit', compact('school'));
    }
    
    public function updateSchool(Request $request, $school_code)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
        ]);
    
        $school = School::where('school_code', $school_code)->firstOrFail();
        $school->update([
            'school_name' => $request->school_name,
        ]);
    
        return redirect()->route('admin.schools')->with('success', 'School updated successfully.');
    }

    public function departments()
{
    return view('admin.departments.index', [
        'departments' => Department::with('school')->get(),
        'schools' => School::all(), // This fixes the undefined variable error
    ]);
}


public function storeDepartment(Request $request)
{
    $validator = Validator::make($request->all(), [
        'department_name' => 'required|string|max:255',
        'school_code' => 'required|exists:schools,school_code',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    Department::create([
        'department_name' => $request->department_name,
        'school_code' => $request->school_code,
    ]);

    return view('admin.departments.index', [
        'departments' => Department::with('school')->get(),
        'schools' => School::all(), 
    ]);
}

//for degress


public function departmentDegrees()
{
    $departmentDegrees = DepartmentDegree::with('department')->get();

    // Create a case-insensitive mapping: lowercase degree name => enum key (like "bsit")
    $enumLabels = collect(DegreeEnum::cases())->mapWithKeys(function ($case) {
        return [strtolower($case->value) => $case->name]; // "bachelor..." => "BSIT"
    });

    // Build labels for degrees based on their enum match (if found)
    $degreeLabels = $departmentDegrees->mapWithKeys(function ($degree) use ($enumLabels) {
        $key = strtolower($degree->degree_name);
        return [$degree->degree_id => $enumLabels[$key] ?? 'N/A'];
    });

    return view('admin.department_degrees.index', [
        'departmentDegrees' => $departmentDegrees,
        'departments' => Department::all(),
        'degreeLabels' => $degreeLabels,
    ]);
}
public function storeDepartmentDegree(Request $request)
{
    $validated = $request->validate([
        'degree_name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,department_id',
    ]);

    DepartmentDegree::create($validated);

    return view('admin.department_degrees.index', [
        'departmentDegrees' => DepartmentDegree::with('department')->get(),
        'departments' => Department::all(),
        'total_degree' => DepartmentDegree::count(),
    ]);
}
    
            
// for the teacher ni
public function showTeacher()
{
    $teachers = Teacher::with('department')->get();

    return view('admin.teachers.index', compact('teachers'));
}
public function showCounselor()
{
    $counselors = Counselor::with('user', 'department.school')->paginate(5); // Use paginate()

    return view('admin.counselors.index', compact('counselors'));
}

public function editCounselor($counselorId)
{
    $counselor = Counselor::with('department', 'User')->findOrFail($counselorId);

    // Fetch teachers whose department name is "SDPC department"
    $teachers = Teacher::whereHas('department', function ($query) {
        $query->where('department_name', 'SDPC department');
    })->get();

    return view('admin.counselors.edit', compact('counselor', 'teachers'));
}

public function updateCounselor(Request $request, $counselorId)
{
    // Log the incoming request data
    \Log::info('Update Counselor Request Data:', $request->all());

    // Find the counselor and associated user
    $counselor = Counselor::with('user')->findOrFail($counselorId);
    $userId = $counselor->user_id; // Get the user ID associated with the counselor
    $user = User::findOrFail($userId); // Fetch the associated user

    // Validate incoming request
    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'nullable|email|max:100',
        'username' => 'required|string|max:100',
        'teacher_id' => 'nullable|exists:teachers,id', // Validate teacher ID if provided
    ]);

    // Update counselor's information
    $counselor->first_name = $request->input('first_name');
    $counselor->last_name = $request->input('last_name');
    $counselor->email = $request->input('email');

    // Handle selected teacher if provided
    if ($request->filled('teacher_id')) {
        $teacher = Teacher::findOrFail($request->input('teacher_id'));

        // Flash teacher information to the session
        session()->flash('teacher_info', [
            'first_name' => $teacher->first_name,
            'last_name' => $teacher->last_name,
            'username' => $teacher->user->username,
        ]);

        // Update the counselor's information with the teacher's details
        $counselor->first_name = $teacher->first_name;
        $counselor->last_name = $teacher->last_name;
        $user->username = $teacher->user->username; // Update the associated user's username
    }

    // Update the user's information
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->username = $request->input('username');

    // Save the counselor's updated information
    $counselorSaved = $counselor->save();

    // Save the updated user information
    $userSaved = $user->save();

    // Log save results
    \Log::info('Counselor Save Result:', ['result' => $counselorSaved]);
    \Log::info('User Save Result:', ['result' => $userSaved]);

    // Redirect with success message
    return redirect()->route('admin.counselors.index')->with('success', 'Counselor updated successfully.');
}

public function showdean()
{
    $deans = Dean::with('School')->get();

    return view('admin.dean.index', compact('deans'));
}

public function editDean($deanId)
{
    $dean = Dean::with('School', 'User')->findOrFail($deanId); // Load the user and school relationships
    $teachers = Teacher::all(); // Fetch all teachers

    return view('admin.dean.edit', compact('dean', 'teachers'));
}
public function updateDean(Request $request, $deanId)
{
    // Log the incoming request data
    \Log::info('Update Dean Request Data:', $request->all());

    // Find the dean and associated user
    $dean = Dean::with('user')->findOrFail($deanId);
    $userId = $dean->user_id; // Get the user ID associated with the dean
    $user = User::findOrFail($userId); // Fetch the associated user

    // Validate incoming request
    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'nullable|email|max:100',
        'username' => 'required|string|max:100',
        'teacher_id' => 'nullable|exists:teachers,id', // Validate teacher ID if provided
    ]);

    // Update dean's information
    $dean->first_name = $request->input('first_name');
    $dean->last_name = $request->input('last_name');
    $dean->email = $request->input('email');

    // Handle selected teacher if provided
    if ($request->filled('teacher_id')) {
        $teacher = Teacher::findOrFail($request->input('teacher_id'));

        // Flash teacher information to the session
        session()->flash('teacher_info', [
            'first_name' => $teacher->first_name,
            'last_name' => $teacher->last_name,
            'username' => $teacher->user->username,
        ]);

        // Update the dean's information with the teacher's details
        $dean->first_name = $teacher->first_name;
        $dean->last_name = $teacher->last_name;
        $user->username = $teacher->user->username; // Update the associated user's username
    }

    // Update the user's information
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->username = $request->input('username');


    // Save the dean's updated information
    $deanSaved = $dean->save();

    // Save the updated user information
    $userSaved = $user->save();

    // Log save results
    \Log::info('Dean Save Result:', ['result' => $deanSaved]);
    \Log::info('User Save Result:', ['result' => $userSaved]);

    // Redirect with success message
    return redirect()->route('admin.dean.index')->with('success', 'Dean updated successfully.');
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
            $username = $row[3];

            // Check if the username already exists, case-insensitive comparison
            if (User::whereRaw('LOWER(username) = ?', [strtolower($username)])->exists()) {
                return redirect()->back()->with('error', "User account '{$username}' already exists.");
            }

            // Create a user
            $user = User::create([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'username' => $username,
                'email' => $row[5],
                'password' => Hash::make('12345'),
                'role_id' => 3,
            ]);

            // Find the department degree, case-insensitive comparison
            $degree = DepartmentDegree::whereRaw('LOWER(degree_name) = ?', [strtolower($row[2])])->first();

            if ($degree) {
                $student = new Student([
                    'first_name' => $row[0],
                    'last_name' => $row[1],
                    'year_level' => $row[4],
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
        return redirect()->back()->with('error', 'Error occurred while importing students: ' . $e->getMessage());
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
    
            // Initialize an array to hold error messages
            $errors = [];
    
            foreach ($data as $row) {
                // Check if the username already exists across all users
                if (User::where('username', $row[2])->exists()) {
                    $errors[] = "User account '{$row[2]}' already exists.";
                    continue; // Skip this user and continue with the next
                }
    
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
                        'email' => $user->email,
                    ]);
    
                    $teacher->user()->associate($user);
                    $teacher->department()->associate($department);
                    $teacher->save();
                } else {
                    $errors[] = 'Department not found for teacher: ' . $row[0];
                }
            }
    
            // Check for errors after the import process
            if (!empty($errors)) {
                return redirect()->back()->with('error', implode(', ', $errors));
            }
    
            return redirect()->back()->with('success', 'Teachers imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while importing teachers: '  );
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
            $departmentName = $row[2]; // department name instead of department ID

            // Find the department by name (case-insensitive)
            $department = Department::whereRaw('LOWER(department_name) = ?', [strtolower($departmentName)])->first();

            // If no department is found, log the error and skip the row
            if (!$department) {
                Log::error("Department not found for course: {$courseName}. Skipping.");
                continue;
            }

            // Create the course
            $course = new Course();
            $course->course_code = $courseCode;
            $course->course_name = $courseName;
            $course->department_id = $department->department_id; // Use the department_id from the department found

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
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);
    
        try {
            $file = $request->file('file');
            $data = array_map('str_getcsv', file($file));
    
            foreach ($data as $row) {
                if (count($row) < 7) {
                    Log::error('Invalid row format: ' . implode(',', $row));
                    continue;
                }
    
                $offerCode = $row[0];
                $courseCode = $row[1];
                $semesterId = $row[2];
                $teacherUsername = $row[3];
                $startTime = $row[4];
                $endTime = $row[5];
                $daysOfWeek = $row[6];
    
                $course = Course::where('course_code', $courseCode)->first();
                if (!$course) {
                    Log::error("Course '{$courseCode}' not found.");
                    continue;
                }
    
                $semester = Semester::find($semesterId);
                if (!$semester) {
                    Log::error("Semester ID '{$semesterId}' not found.");
                    continue;
                }
    
                $user = User::where('username', $teacherUsername)->where('role_id', 2)->first();
                if (!$user) {
                    Log::error("User '{$teacherUsername}' with role 'Teacher' not found.");
                    continue;
                }
    
                $teacher = Teacher::where('user_id', $user->user_id)->first();
                if (!$teacher) {
                    Log::error("Teacher linked to user '{$teacherUsername}' not found.");
                    continue;
                }
    
                CourseOffering::create([
                    'offer_code' => $offerCode,
                    'course_code' => $courseCode,
                    'semester_id' => $semesterId,
                    'teacher_id' => $teacher->teacher_id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'days_of_week' => $daysOfWeek,
                ]);
            }
    
            return redirect()->back()->with('success', 'Course offerings imported successfully.');
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error during course offerings import.');
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
        $userId = $row[0]; 
        $fileName = $row[1]; 

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
        'file' => 'required|mimes:csv,txt|max:2048'
    ]);

    try {
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));

        // Remove the header row
        array_shift($data);

        foreach ($data as $row) {
            // Expecting: username, semester_id, offer_code
            if (count($row) !== 3) {
                throw new \Exception("Invalid row format. Each row must contain username, semester ID, and offer code.");
            }

            $username = $row[0];
            $semesterId = $row[1];
            $offerCode = $row[2];

            // Get the user by username with student role
            $user = User::where('username', $username)->where('role_id', 3)->first();
            if (!$user) {
                \Log::error("User with username '{$username}' and role 'Student' not found.");
                continue;
            }

            // Get the associated student record
            $student = Student::where('user_id', $user->user_id)->first();
            if (!$student) {
                \Log::error("Student record not found for user '{$username}'.");
                continue;
            }

            // Create or retrieve the study load
            $studyLoad = StudyLoad::firstOrCreate([
                'student_id' => $student->student_id,
                'semester_id' => $semesterId,
            ]);

            // Attach course offering
            $studyLoad->courseOfferings()->syncWithoutDetaching([$offerCode]);
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


//for school year
public function indexSchoolYear()
    {
        $schoolYears = SchoolYear::all();
        $semesters = Semester::all();

        return view('admin.school_years.index', compact('schoolYears', 'semesters'));

    }
    public function activateSchoolYear($syId)
{
    $schoolYear = SchoolYear::findOrFail($syId);

    // Check if the school year is already active
    if ($schoolYear->is_active) {
        return redirect()->back()->with('info', 'School year is already active.');
    }

    // Activate the selected school year
    $schoolYear->is_active = true;
    $schoolYear->save();

    // Create semesters for the newly activated school year
    $semesters = [
        ['semester_name' => $schoolYear->sy_name . ' 1st sem', 'sy_id' => $schoolYear->sy_id],
        ['semester_name' => $schoolYear->sy_name . ' 2nd sem', 'sy_id' => $schoolYear->sy_id],
        ['semester_name' => $schoolYear->sy_name . ' Summer', 'sy_id' => $schoolYear->sy_id],
        // Add more semester records here if needed
    ];

    // Check if semesters already exist to avoid duplicates
    foreach ($semesters as $semester) {
        Semester::firstOrCreate($semester);
    }

    return redirect()->back()->with('success', 'School year activated successfully.');
}
    
public function addSchoolYear(Request $request)
{
    $validator = Validator::make($request->all(), [
        'sy_id' => 'required|unique:school_years,sy_id|regex:/^\d{4}$/',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $year = $request->input('sy_id');
    $schoolYear = new SchoolYear();
    $schoolYear->sy_id = $year . '-' . ($year + 1);
    $schoolYear->sy_name = 'SY ' . $schoolYear->sy_id;
    $schoolYear->is_active = false; // Set to false initially
    $schoolYear->save();

    // Automatically activate the school year now
    return $this->activateSchoolYear($schoolYear->sy_id);
}

public function showCourseOfferingsAndCourses(Request $request)
{
    $courseSearch = $request->input('course_search');
    $offeringSearch = $request->input('offering_search');

    // Search and paginate Courses
    $allCourses = Course::query()
        ->when($courseSearch, function ($query, $courseSearch) {
            $query->where('course_code', 'like', "%{$courseSearch}%")
                  ->orWhere('course_name', 'like', "%{$courseSearch}%");
        })
        ->paginate(10, ['*'], 'courses_page'); // separate pagination name

    // Search and paginate Course Offerings
    $allCourseOfferings = CourseOffering::with(['course.department.school', 'teacher.user'])
        ->when($offeringSearch, function ($query, $offeringSearch) {
            $query->where('offer_code', 'like', "%{$offeringSearch}%")
                  ->orWhereHas('course', function ($q) use ($offeringSearch) {
                      $q->where('course_code', 'like', "%{$offeringSearch}%")
                        ->orWhere('course_name', 'like', "%{$offeringSearch}%");
                  });
        })
        ->paginate(10, ['*'], 'offerings_page'); // separate pagination name

    return view('admin.course.index', compact('allCourseOfferings', 'allCourses'));
}

}