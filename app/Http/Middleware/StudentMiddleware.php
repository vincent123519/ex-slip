<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use App\Models\UserRole; // Import the UserRole model

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Your middleware logic goes here
        if (auth()->check() && $this->isStudent(auth()->user())) {
            return $next($request);
        }

        return redirect(route('student.dashboard'))->with('error', 'You do not have access to this page.');
        }

    /**
     * Check if the user has the 'student' role.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    private function isStudent(User $user)
    {
        // You can modify this logic based on your actual role implementation
        return $user->hasRole('student');
    }
    
}
