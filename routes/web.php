<?php

use App\Models\Teacher;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeanController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\ExcuseSlipController;
use App\Http\Controllers\HeadCounselorController;

Route::get('/reports', [ReportController::class, 'viewReports'])
    ->name('reports.view');



// Route::get('/excuse_slips', [ExcuseSlipController::class, 'index'])->name('excuse_slips.index');

// Route::get('/excuse_slips/list', [ExcuseSlipController::class, 'studentExcuseSlipList'])->name('student.dashboard');
Route::get('/excuse_slips/create', [ExcuseSlipController::class, 'createExcuseSlip'])->name('excuse_slips.create');
Route::post('/excuse_slips', [ExcuseSlipController::class, 'store'])->name('excuse_slips.store');
Route::get('/excuse_slips/{id}/edit', [ExcuseSlipController::class, 'edit'])->name('excuse_slips.edit');
Route::put('/excuse_slips/{id}', [ExcuseSlipController::class, 'update'])->name('excuse_slips.update');
Route::delete('/excuse_slips/{id}', [ExcuseSlipController::class, 'destroy'])->name('excuse_slips.destroy');
Route::get('/excuse_slips/{excuse_slip_id}', [ExcuseSlipController::class, 'show'])->name('excuse_slips.show');

Route::put('/excuse_slips/{id}', [ExcuseSlipController::class, 'update'])->name('excuse_slips.update');


// In web.php
Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password.update');


// Student Routes
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
//
// routes/web.php



Route::group(['middleware' => ['web', 'student']], function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

});



// web.php
// routes/web.php
// routes/web.php


Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

Route::get('/counselor/dashboard', [CounselorController::class, 'dashboard'])->name('counselor.dashboard');
Route::put('/excuse_slips/reject/{id}', [CounselorController::class, 'reject'])->name('excuse.reject');

Route::post('/excuse_slips/{id}/counselor_feedback', [CounselorController::class, 'storeFeedback'])
    ->name('counselor.feedback.store');
Route::post('/excuse_slips/{id}/dean_feedback', [DeanController::class, 'deanStoreFeedback'])
    ->name('dean.feedback.store');
Route::post('/excuse_slips/{id}/teacher_feedback', [TeacherController::class, 'teacherStoreFeedback'])
    ->name('teacher.feedback.store');



Route::post('/{excuseSlipId}/send-to-teacher/{teacherId}', [DeanController::class, 'sendToTeacher'])
    ->name('excuse-slips.send-to-teacher');
    Route::get('/dean/dashboard', [DeanController::class, 'dashboard'])->name('dean.dashboard');



// approval reques slip
Route::put('/excuse_slips/approvedean/{id}', [DeanController::class, 'approveExcuseSlip'])->name('excuse.approvedean');
Route::put('/excuse_slips/approve/{id}', [CounselorController::class, 'approve'])->name('excuse.approve');
Route::put('/excuse_slips/approveteacher/{id}', [TeacherController::class, 'signExcuseSlip'])->name('excuse.approveteacher');



Route::put('/excuse_slips/reject/{id}', [DeanController::class, 'rejectExcuseSlip'])->name('excuse.reject');


Route::get('/head-counselor/assign', [HeadCounselorController::class, 'showAssignForm'])->name('head-counselor.assign.form');
Route::post('/head-counselor/assign', [HeadCounselorController::class, 'assignCounselor'])->name('head-counselor.assign');

Route::get('/head-counselor', [HeadCounselorController::class, 'index'])->name('head-counselor.index');


//admin
Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
Route::get('/edit-user/{user}', [AdminController::class, 'editUser'])->name('edit-user');

Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');

Route::put('/update-user/{user}', [AdminController::class, 'updateUser'])->name('update-user');

// User Registration
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register');

// User Login

// Show login form
Route::get('/', [UserController::class, 'showLoginForm'])->name('login');

// Handle login submission (POST)
Route::post('/', [UserController::class, 'login']);

// Handle role selection (POST)
Route::post('/redirect-role', function (Request $request) {
    $userId = $request->input('user_id');
    $roleId = $request->input('role_id');
    $username = $request->input('username');

    // Retrieve the correct user instance
    $user = User::where('user_id', $userId)->where('username', $username)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Log in the selected user (to ensure correct role-based session)
    Auth::login($user);

    // Redirect to the correct dashboard based on role
    return response()->json([
        'redirect_url' => route($this->getRoleDashboard($roleId)) // Use the method here
    ]);
})->name('redirectRole');

Route::post('/select-role-login', [UserController::class, 'selectRoleLogin'])->name('selectRoleLogin');


// User Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// User Profile
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile'); // Corrected route name

// Change Password
Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/change-password', [UserController::class, 'changePassword']);

// Delete Account
Route::get('/delete-account', [UserController::class, 'showDeleteAccountForm'])->name('delete-account');
Route::post('/delete-account', [UserController::class, 'deleteAccount']);

//for logout function

Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');

//teacher

Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
Route::delete('/excuse/{id}', [TeacherController::class, 'delete'])->name('excuse.delete');


//POST test

Route::post('/add-course', [CourseController::class, 'store']);

Route::get('admin/students', [AdminController::class, 'showStudents'])->name('admin.students.index');
Route::post('/studyload/{studentId}', [AdminController::class, 'storeStudyLoad'])->name('studyload.store');
Route::get('/studyload/create/{studentId}', [AdminController::class, 'createStudyLoad'])->name('admin.studyload.create');
Route::post('/admin/studyload/store', [AdminController::class, 'storeStudyLoad'])->name('admin.studyload.store');
Route::get('admin/teachers', [AdminController::class, 'showTeacher'])->name('admin.teachers.index');
Route::get('admin/excuseslip', [AdminController::class, 'showExcuseslip'])->name('admin.excuseslip.index');

Route::get('/admin/counselors', [AdminController::class, 'showCounselor'])->name('admin.counselors.index');
Route::get('/admin/counselors/edit/{counselor}', [AdminController::class, 'editCounselor'])->name('admin.counselor.edit');
Route::put('/admin/counselors/update/{counselor}', [AdminController::class, 'updateCounselor'])->name('admin.counselors.update');

Route::get('/admin/dean', [AdminController::class, 'showdean'])->name('admin.dean.index');
Route::get('/admin/dean/edit/{dean}', [AdminController::class, 'editDean'])->name('admin.dean.edit');
Route::put('/admin/dean/update/{dean}', [AdminController::class, 'updateDean'])->name('admin.dean.update');
Route::put('/admin/dean/{deanId}/promote', [AdminController::class, 'promote'])->name('admin.dean.promote');

Route::get('/admin/schools', [AdminController::class, 'schools'])->name('admin.schools');
Route::post('/admin/schools/store', [AdminController::class, 'storeSchool'])->name('admin.schools.store');

Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments');
Route::post('/departments/store', [AdminController::class, 'storeDepartment'])->name('admin.departments.store');





// routes/web.php


Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// import csv

Route::post('/admin/import-students', [AdminController::class, 'importStudents'])->name('admin.import.students');

Route::get('/admin/import', [AdminController::class, 'showImportForm'])->name('admin.import.index');
Route::post('/admin/import-teachers', [AdminController::class, 'importTeachers'])->name('admin.import.teachers');
Route::post('/admin/import-courses', [AdminController::class, 'importCourses'])->name('admin.import.courses');
Route::post('/import-course-offerings', [AdminController::class, 'importCourseOfferings'])->name('import.course.offerings.form');

Route::get('/excuse-slips/export', [ExcuseSlipController::class, 'export'])->name('excuse_slips.export');
Route::post('/import-study-load', [AdminController::class, 'importStudyLoad'])->name('import.studyload');
Route::post('/upload-user-images', [AdminController::class, 'uploadUserImages'])->name('upload.user.images');

//notificationapp


Route::put('/excuse_slips/{excuseSlipId}/mark-as-read', [CounselorController::class, 'markAsRead'])->name('excuse_slips.mark_as_read');
Route::put('/excuse_slips/{excuseSlipId}/mark-as-read-by-dean', [DeanController::class, 'markAsReadByDean'])->name('excuse_slips.markAsReadByDean');
Route::put('/excuse_slips/{excuseSlipId}/mark-as-read-by-teacher', [TeacherController::class, 'markAsReadByTeacher'])->name('excuse_slips.markAsReadByTeacher');


//edit detailes

Route::get('/admin/students/{id}/edit', [AdminController::class, 'editStudentDetails'])
    ->name('admin.students.edit');

Route::put('/admin/students/{id}', [AdminController::class, 'updateStudentDetails'])
    ->name('admin.students.update');

Route::get('/admin/school_years', [AdminController::class, 'indexSchoolYear'])->name('admin.school_years.index');

Route::post('/school_years/{syId}/activate', [AdminController::class, 'activateSchoolYear'])->name('school-year.activate');
Route::post('/school_years', [AdminController::class, 'addSchoolYear'])->name('school-year.add');

//

Route::get('/admin/course_offerings_and_courses', [AdminController::class, 'showCourseOfferingsAndCourses'])
    ->name('admin.course_offerings_and_courses');