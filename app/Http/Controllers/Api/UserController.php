<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Student;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HeadCounselor;
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
        $roles = UserRole::all(); // Retrieve all available roles
        return view('user.register', ['roles' => $roles]);
    }

    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $this->validator($request->all());

        // If validation fails, return back with errors
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        // Create the user and save the password
        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')), // Hash the password
            'role_id' => $request->input('role'), // Assuming role is stored in role_id field
        ]);

        // Check the role and perform role-specific actions
        if ($user->role_id == 1) {
            $headCouncelor = new HeadCounselor([
                'name' => $user->name,
            ]);

            $user->headCouncelor()->save($headCouncelor);
        } elseif ($user->role_id == 2) {
            // Teacher role
            // Example: Teacher-specific logic
        } elseif ($user->role_id == 4) {
            // Counselor role
            // Example: Counselor-specific logic
        } elseif ($user->role_id == 5) {
            // Dean role
            // Example: Dean-specific logic
        } elseif ($user->role_id == 3) {
            // Student role
            $student = new Student([
                'name' => $user->name,
                // Other student attributes
            ]);

            // Save the student record
            $user->student()->save($student);
        }

        // Redirect to the login page
        return redirect()->route('login')->with('success', 'User registered successfully');
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
     * Change the user's password.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'current_password'=> 'required',
            'new_password' => 'required|min:6',
        ]);

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect',
            ])->status(422);
        }

        $user->update([
            'password' => Hash::make($validatedData['new_password']),
        ]);

        // Add any additional logic or actions after changing the user's password

        return response()->json(['message' => 'User password changed successfully']);
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


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'exists:user_roles,role_id'], // Update to use 'role_id'
        ]);
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    /**
     * User login.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */


// UserController.php





     
}

     
        


     


