<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\User;
use App\Models\HeadCounselor;

class HeadCounselorSeeder extends Seeder
{
    public function run()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            $username = 'hc' . Str::random(8);

            // Create a new User record without specifying user_id
            $user = new User();
            $user->name = 'Head Counselor';
            $user->username = $username;
            $user->password_hash = Hash::make('password');
            $user->role_id = 1; // Replace '1' with the appropriate role ID for head counselor
            $user->save(); // The database will assign a unique user_id

            // Now, create a new HeadCounselor record and associate it with the user
            $headCounselor = new HeadCounselor();
            $headCounselor->name = 'Head Counselor';
            $headCounselor->department_id = $department->department_id;

            // Associate the user with the head counselor
            $headCounselor->user()->associate($user); // Use the 'associate' method
            $headCounselor->save();
        }
    }
}
