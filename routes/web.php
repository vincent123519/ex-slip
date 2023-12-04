<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\UserController;


// use App\Http\Controllers\AdminController;

// use App\Http\Controllers\HeadCounselorController;

// use App\Http\Controllers\StudentController;

// // routes/web.php

// use App\Http\Controllers\ExcuseSlipController;

// // routes/web.php

// use App\Http\Controllers\ReportController;

// Route::get('/reports', [ReportController::class, 'viewReports'])
//     ->name('reports.view');

// Route::get('/feedback/{excuseSlipId}', [FeedbackController::class, 'showFeedbackForm'])
//     ->name('feedback.form');

// Route::post('/feedback/submit', [FeedbackController::class, 'submitFeedback'])
//     ->name('feedback.submit');

// Route::get('/excuse_slips', [ExcuseSlipController::class, 'index'])->name('excuse_slips.index');
// Route::get('/excuse_slips/create', [ExcuseSlipController::class, 'create'])->name('excuse_slips.create');
// Route::post('/excuse_slips', [ExcuseSlipController::class, 'store'])->name('excuse_slips.store');
// Route::get('/excuse_slips/{id}', [ExcuseSlipController::class, 'show'])->name('excuse_slips.show');
// Route::get('/excuse_slips/{id}/edit', [ExcuseSlipController::class, 'edit'])->name('excuse_slips.edit');
// Route::put('/excuse_slips/{id}', [ExcuseSlipController::class, 'update'])->name('excuse_slips.update');
// Route::delete('/excuse_slips/{id}', [ExcuseSlipController::class, 'destroy'])->name('excuse_slips.destroy');

// Route::get('/excuse_slips/{id}/view', [ExcuseSlipController::class, 'viewExcuseSlip'])->name('excuse_slips.view');

// // Student Routes
// Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
// Route::post('/students', [StudentController::class, 'store'])->name('students.store');
// Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
// Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
// Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
// Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
// Route::get('/students/{id}/request-excuse-slip', 'StudentController@requestExcuseSlip')->name('students.request_excuse_slip');


// Route::get('/head-counselor/assign', [HeadCounselorController::class, 'showAssignForm'])->name('head-counselor.assign.form');
// Route::post('/head-counselor/assign', [HeadCounselorController::class, 'assignCounselor'])->name('head-counselor.assign');

// Route::get('/head-counselor', [HeadCounselorController::class, 'index'])->name('head-counselor.index');


// //admin
// Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
// Route::get('/edit-user/{user}', [AdminController::class, 'editUser'])->name('edit-user');

// Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');

// Route::put('/update-user/{user}', [AdminController::class, 'updateUser'])->name('update-user');

// // User Registration
// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [UserController::class, 'register'])->name('register');

// // // User Login
// // Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
// // Route::post('/login', [UserController::class, 'login']);

// // // User Logout
// // Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// // Login
// Route::match(['get', 'post'], '/login', 'UserController@login')->name('login');

// // User Profile
// Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
// Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile'); // Corrected route name

// // Change Password
// Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
// Route::post('/change-password', [UserController::class, 'changePassword']);

// // Delete Account
// Route::get('/delete-account', [UserController::class, 'showDeleteAccountForm'])->name('delete-account');
// Route::post('/delete-account', [UserController::class, 'deleteAccount']);

// // User Registration
// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [UserController::class, 'register'])->name('register');

// // Login
// Route::match(['get', 'post'], '/login', [UserController::class, 'login'])->name('login');

// // Logout
// Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// // User Profile
// Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
// Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');

// // Change Password
// Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
// Route::post('/change-password', [UserController::class, 'changePassword']);

// // Delete Account
// Route::get('/delete-account', [UserController::class, 'showDeleteAccountForm'])->name('delete-account');
// Route::post('/delete-account', [UserController::class, 'deleteAccount']);



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HeadCounselorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExcuseSlipController;
use App\Http\Controllers\ReportController;

// Reports
Route::get('/reports', [ReportController::class, 'viewReports'])->name('reports.view');

// Feedback
Route::get('/feedback/{excuseSlipId}', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.form');
Route::post('/feedback/submit', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

// Excuse Slips
Route::resource('/excuse_slips', ExcuseSlipController::class)->except(['show']);
Route::get('/excuse_slips/{id}/view', [ExcuseSlipController::class, 'viewExcuseSlip'])->name('excuse_slips.view');

// Students
Route::resource('/students', StudentController::class);
Route::get('/students/{user_id}', [StudentController::class, 'show'])->name('students.show');


// Head Counselor
Route::get('/head-counselor/assign', [HeadCounselorController::class, 'showAssignForm'])->name('head-counselor.assign.form');
Route::post('/head-counselor/assign', [HeadCounselorController::class, 'assignCounselor'])->name('head-counselor.assign');
Route::get('/head-counselor', [HeadCounselorController::class, 'index'])->name('head-counselor.index');

// Admin
Route::get('/admin', [AdminController::class, 'manageUsers'])->name('manage-users');
Route::get('/edit-user/{user}', [AdminController::class, 'editUser'])->name('edit-user');
Route::delete('/delete-user/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');
Route::put('/update-user/{user}', [AdminController::class, 'updateUser'])->name('update-user');

// User
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// Login
// Login
Route::match(['get', 'post'], '/', [UserController::class, 'showLoginForm'])->name('login');
// Logout  
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');

Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/change-password', [UserController::class, 'changePassword']);

Route::get('/delete-account', [UserController::class, 'showDeleteAccountForm'])->name('delete-account');
Route::post('/delete-account', [UserController::class, 'deleteAccount']);
