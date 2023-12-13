<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dean;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeansSeeder extends Seeder
{
    public function run()
    {
        // Retrieve existing users and departments
        $this->call(DepartmentSeeder::class);

        // Create counselors with existing user and department IDs
        $deansData = [
            [
                'first_name' => 'Juvylyn',
                'last_name' => 'Cuizon',
                'department' => 'Information Technology Department',
                'username' => 'juvelyn.Cuizon',
            ],
            // Add more sample counselors
        ];

        foreach ($deansData as $deansData) {
            // Find the user and department based on the provided IDs
            $user = User::create([
                'first_name' => $deansData['first_name'],
                'last_name' => $deansData['last_name'],
                'username' => $deansData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 5,
            ]);

            // Find the department
            $department = Department::where('department_name', $deansData['department'])->first();

            

            // Create and save the counselor
            $dean = new Dean([
                'first_name' => $deansData['first_name'],
                'last_name' => $deansData['last_name'],

            ]);

            $dean->user()->associate($user);
            $dean->department()->associate($department);
            $dean->save();
        }
    }
}
