<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\DepartmentDegree;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Run the DepartmentDegreeSeeder to seed department degrees
        $this->call(DepartmentDegreeSeeder::class);

        $students = [
            [
                'name' => 'John Doe',
                'degree' => 'Bachelor of Science in Computer Science',
                'username' => 'john.doe',
                'year_level' => 2,
            ],
            [
                'name' => 'Jane Smith',
                'degree' => 'Bachelor of Science in Information Technology',
                'username' => 'jane.smith',
                'year_level' => 3,
            ],
            // Add more student records here with their respective year levels and degrees
        ];

        foreach ($students as $studentData) {
            // Create a user with a username and set a default password
            $user = User::create([
                'name' => $studentData['name'],
                'username' => $studentData['username'],
                'password_hash' => Hash::make('password'), // You can set a default password
            ]);

            // Find the department degree
            $degree = DepartmentDegree::where('degree_name', $studentData['degree'])->first();

            $student = new Student([
                'name' => $studentData['name'],
                'year_level' => $studentData['year_level'],
            ]);

            $student->user()->associate($user);
            $student->degree()->associate($degree);
            $student->save();
        }
    }
}
