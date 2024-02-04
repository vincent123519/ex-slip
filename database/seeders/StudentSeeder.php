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
                'first_name' => 'Christian',
                'last_name' => 'Morales',
                'degree' => 'Bachelor of Science in Computer Science',
                'username' => '2019012',
                'year_level' => 2,
            ],
            [
                'first_name' => 'Vincent John',
                'last_name' => 'Orat',
                'degree' => 'Bachelor of Science in Information Technology',
                'username' => '2020012',
                'year_level' => 3,
            ],
            [
                'first_name' => 'Sweet Jam',
                'last_name' => 'Yu',
                'degree' => 'Bachelor of Science in Information Technology',
                'username' => '2018012',
                'year_level' => 1,
            ],

            [
                'first_name' => 'Jeriel',
                'last_name' => 'Orias',
                'degree' => 'Bachelor of civil engineering',
                'username' => '2023012',
                'year_level' => 1,
            ],
            // Add more student records here with their respective first names, last names, year levels, and degrees
        ];

        foreach ($students as $studentData) {
            // Create a user with a username and set a default password
            $user = User::create([
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'middle_name' => $studentData['middle_name'] ?? null, // Check if the key exists
                'title' => $studentData['title'] ?? null, // Check if the key exists
                'username' => $studentData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 3, // Replace 3 with the actual role ID for students
            ]);

            // Find the department degree
            $degree = DepartmentDegree::where('degree_name', $studentData['degree'])->first();

            $student = new Student([
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'year_level' => $studentData['year_level'],
            ]);

            $student->user()->associate($user);
            $student->degree()->associate($degree);
            $student->save();
        }
    }
}
    