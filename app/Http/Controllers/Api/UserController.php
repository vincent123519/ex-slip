<?php

namespace App\Http\Controllers\Api;

use App\Models\Dean;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserRole;
use App\Models\Counselor;
use Illuminate\Http\Request;
use App\Models\HeadCounselor;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Show the user registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        $roles = UserRole::all();
        return view('user.registration_form', compact('roles'));
    }

    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $this->validator($request->all());

            if ($validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }

            DB::beginTransaction();

            // Create the user and save the password
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $request->input('role'),
                'first_time_login' => true,  // New users will need to change their password
            ]);

            // Role-specific actions
            switch ($user->role_id) {
                case 1:
                    $headCounselor = new HeadCounselor([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]);
                    $user->headCounselor()->save($headCounselor);
                    break;
                case 2:
                    $teacher = new Teacher([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]);
                    $user->teacher()->save($teacher);
                    break;
                case 3:
                    $student = new Student([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]);
                    $user->student()->save($student);
                    break;
                case 4:
                    $counselor = new Counselor([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]);
                    $user->counselor()->save($counselor);
                    break;
                case 5:
                    $dean = new Dean([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]);
                    $user->dean()->save($dean);
                    break;
                default:
                    break;
            }

            DB::commit();

            return redirect()->route('login')->with('success', 'User registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during registration.');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'integer', Rule::in(UserRole::pluck('role_id'))],
        ]);
    }

    /**
     * User login.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
/**
 * User login.
 *
 * @param  Request  $request
 * @return \Illuminate\Http\RedirectResponse
 * @throws ValidationException
 */
public function login(Request $request)
{
    $validatedData = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = User::with('role')->where('username', $validatedData['username'])->first();

    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
        throw ValidationException::withMessages([
            'message' => 'Invalid username or password',
        ])->status(401);
    }

    Auth::login($user);

    // Log the user information for debugging purposes
    \Illuminate\Support\Facades\Log::info('User Information: ' . json_encode($user->toArray()));

    // Check if the user is logging in for the first time, but exclude admins (role_id = 6)
    if ($user->first_time_login && $user->role_id !== 6) {
        // Redirect to change password page for non-admin users
        return redirect()->route('change-password')->with('warning', 'Please change your password for the first time.');
    }

    // Redirect based on the user's role
    switch ($user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard')->with('success', 'Admin logged in successfully');
        case 2:
            return redirect()->route('teacher.dashboard')->with('success', 'Teacher logged in successfully');
        case 3:
            return redirect()->route('student.dashboard')->with('success', 'Student logged in successfully');
        case 4:
            return redirect()->route('counselor.dashboard')->with('success', 'Counselor logged in successfully');
        case 5:
            return redirect()->route('dean.dashboard')->with('success', 'Dean logged in successfully');
        case 6:
            return redirect()->route('admin.dashboard')->with('success', 'Admin logged in successfully');
        default:
            return redirect()->route('default.dashboard')->with('success', 'Logged in successfully');
    }
}



    /**
     * Change the user's password.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
/**
 * Change the user's password.
 *
 * @param  Request  $request
 * @return \Illuminate\Http\RedirectResponse
 * @throws ValidationException
 */
public function changePassword(Request $request)
{
    $user = $request->user();
    
    // Validate the incoming request
    $validatedData = $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6',
    ]);
    
    // Check if the current password matches the user's stored password
    if (!Hash::check($validatedData['current_password'], $user->password)) {
        throw ValidationException::withMessages([
            'current_password' => 'Current password is incorrect',
        ])->status(422);
    }
    
    // Update user's password
    $user->update([
        'password' => Hash::make($validatedData['new_password']),
    ]);
    
    // If this was the first-time login and the user is not an admin, update the flag
    if ($user->first_time_login && $user->role_id != 6) {
        $user->first_time_login = false;
        $user->save();
    }

    // Redirect based on user role
    switch ($user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard')->with('success', 'Password changed successfully');
        case 2:
            return redirect()->route('teacher.dashboard')->with('success', 'Password changed successfully');
        case 3:
            return redirect()->route('student.dashboard')->with('success', 'Password changed successfully');
        case 4:
            return redirect()->route('counselor.dashboard')->with('success', 'Password changed successfully');
        case 5:
            return redirect()->route('dean.dashboard')->with('success', 'Password changed successfully');
        default:
            return redirect()->route('default.dashboard')->with('success', 'Password changed successfully');
    }
}

    

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logout successful');
    }

    /**
     * Update the user's profile image.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images/' . $user->id, 'public');
            $user->image = $imagePath;
            $user->save();
        }

        return response()->json(['message' => 'Profile image updated successfully']);
    }



    /**
     * Show the user profile.
     *
     * @return \Illuminate\Contracts\View\View
     */
    

    /**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id . ',id',
        ]);

        $user->update($validatedData);

        // Add any additional logic or actions after updating the user's profile

        return response()->json(['message' => 'User profile updated successfully']);
    }

    /**
     * Show the change password form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showChangePasswordForm()
    {
        return view('user.change_password');
    }


    /**
     * Show the delete account form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showDeleteAccountForm()
    {
        return view('user.delete_account');
    }

    /**
     * Delete the user's account.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        // Add any additional logic or actions before deleting the user's account

        $user->delete();

        // Add any additional logic or actions after deleting the user's account

        return response()->json(['message' => 'User account deleted successfully']);
    }
    // Assuming your controller method where you fetch users looks like this:

    public function manageUsers()
    {
        $users = User::with('user_roles')->get();
    
        return view('your-view', compact('users'));
    }

    
    public function showLoginForm()
    {
        return view('user.login');
    }





     
        


     
}

