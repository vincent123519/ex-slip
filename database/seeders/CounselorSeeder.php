<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counselor;
use App\Models\User;
use App\Models\Department;

class CounselorSeeder extends Seeder
{
    public function run()
    {
        // Retrieve existing users and departments
        $users = User::all();
        $departments = Department::all();

        // Create counselors with existing user and department IDs
        $counselors = [
            ['user_id' => 10001, 'name' => 'Counselor 1', 'department_id' => 20001],
            ['user_id' => 10002, 'name' => 'Counselor 2', 'department_id' => 20002],
            // Add more sample counselors
        ];

        // Create the counselors
        foreach ($counselors as $counselorData) {
            // Find the user and department based on the provided IDs
            $user = $users->firstWhere('user_id', $counselorData['user_id']);
            $department = $departments->firstWhere('department_id', $counselorData['department_id']);

            // Check if user and department are found
            if ($user && $department) {
                $counselor = new Counselor([
                    'name' => $counselorData['name'],
                ]);

                $counselor->user()->associate($user);
                $counselor->department()->associate($department);
                $counselor->save();
            } else {
                // Handle the case where user or department is not found
                // You can log an error or take other appropriate action
            }
        }
    }
}
