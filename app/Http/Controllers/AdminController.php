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
        'pending_excuses' => ExcuseSlip::whereIn('status_id', [1, 2, 4])->count(),
        'approved_excuses' => ExcuseSlip::where('status_id', 5)->count(),
        'rejected_excuses' => ExcuseSlip::where('status_id', 3)->count(),
        'total_schools' => School::count(),
        'total_departments' => Department::count(),

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
            'departments' => Department::all(),
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
    $counselors = Counselor::all();

    return view('admin.counselors.index', compact('counselors'));
}
public function editCounselor($counselorId)
{
    $counselor = Counselor::with('department', 'User')->findOrFail($counselorId); // Load the user and school relationships
    $teachers = Teacher::all(); // Fetch all teachers

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

            // Check if the username already exists
            if (User::where('username', $username)->exists()) {
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

            // Find the department degree
            $degree = DepartmentDegree::where('degree_name', $row[2])->first();

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
        return redirect()->back()->with('error', 'Error occurred while importing students: ');
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
                continue; 
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
                continue; 
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

public function showCourseOfferingsAndCourses()
    {
        $allCourseOfferings = CourseOffering::all();
        $allCourses = Course::all();

        return view('admin.course.index', compact('allCourseOfferings', 'allCourses'));
    }
}