<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Counselor;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CounselorSeeder extends Seeder
{
    public function run()
    {
        // Retrieve existing users and departments
        $this->call(DepartmentSeeder::class);

        // Create counselors with existing user and department IDs
        $counselorsData = [
            [
                'name' => 'Ms. Jocelyn Martinez',
                'department' => 'Information Techonology Department',
                'username' => 'jocelyn.martinez',
            ],
            // Add more sample counselors
        ];

        foreach ($counselorsData as $counselorData) {
            // Find the user and department based on the provided IDs
            $user = User::create([
                'name' => $counselorData['name'],
                'username' => $counselorData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 4,
            ]);

            // Find the department
            $department = Department::where('department_name', $counselorData['department'])->first();

            

            // Create and save the counselor
            $counselor = new Counselor([
                'name' => $counselorData['name'],
            ]);

            $counselor->user()->associate($user);
            $counselor->department()->associate($department);
            $counselor->save();
        }
    }
}
