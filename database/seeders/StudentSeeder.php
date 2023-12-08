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
                'name' => 'Dan Lock',
                'degree' => 'Bachelor of Science in Computer Science',
                'username' => '2019012',
                'year_level' => 2,
            ],
            [
                'name' => 'Arkei Tech',
                'degree' => 'Bachelor of Science in Information Technology',
                'username' => '2020012',
                'year_level' => 3,
            ],
            [
                'name' => 'Rhey Peter',
                'degree' => 'Bachelor of Science in Information Technology',
                'username' => '2018012',
                'year_level' => 1,

            ],
            // Add more student records here with their respective year levels and degrees
        ];

        foreach ($students as $studentData) {
            // Create a user with a username and set a default password
            $user = User::create([
                'name' => $studentData['name'],
                'username' => $studentData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 3, // Replace 1 with the actual role ID
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
