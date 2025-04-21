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
                'first_name' => 'Jocelyn',
                'last_name' => 'Martinez',
                'username' => 'jocelyn.martinez',
                'email' => 'jocelyn@gmail.com',
                'department' => 'School of Computer Studies',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Engineering',
                'username' => 'counselor.engineering',
                'email' => 'engineering@gmail.com',
                'department' => 'Computer Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Electrical',
                'username' => 'counselor.electrical',
                'email' => 'electrical@gmail.com',
                'department' => 'Electrical Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Civil',
                'username' => 'counselor.civil',
                'email' => 'civil@gmail.com',
                'department' => 'Civil Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Electronics',
                'username' => 'counselor.electronics',
                'email' => 'electronics@gmail.com',
                'department' => 'Electronics Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Industrial',
                'username' => 'counselor.industrial',
                'email' => 'industrial@gmail.com',
                'department' => 'Industrial Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Mechanical',
                'username' => 'counselor.mechanical',
                'email' => 'mechanical@gmail.com',
                'department' => 'Mechanical Engineering Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Accountancy',
                'username' => 'counselor.accountancy',
                'email' => 'accountancy@gmail.com',
                'department' => 'Accountancy and Finance Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Entrepreneurship',
                'username' => 'counselor.entrepreneurship',
                'email' => 'entrepreneurship@gmail.com',
                'department' => 'Business and Entrepreneurship Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Marketing',
                'username' => 'counselor.marketing',
                'email' => 'marketing@gmail.com',
                'department' => 'Marketing And Human Resource Management Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Tourism',
                'username' => 'counselor.tourism',
                'email' => 'tourism@gmail.com',
                'department' => 'Tourism and Hospitality Management Department',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Psychology',
                'username' => 'counselor.psychology',
                'email' => 'psychology@gmail.com',
                'department' => 'Department of Psychology and Library Information Science',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Communication',
                'username' => 'counselor.communication',
                'email' => 'communication@gmail.com',
                'department' => 'Department of  Communication, Languages, and Literature',
            ],
            [
                'first_name' => 'Counselor',
                'last_name' => 'Education',
                'username' => 'counselor.education',
                'email' => 'education@gmail.com',
                'department' => 'Department of Mathematics and Sciences',
            ],
        ];

        foreach ($counselorsData as $counselorData) {
            $user = User::create([
                'first_name' => $counselorData['first_name'],
                'last_name' => $counselorData['last_name'],
                'username' => $counselorData['username'],
                'email' => $counselorData['email'],
                'password' => Hash::make('12345'),
                'role_id' => 4,
            ]);

            $department = Department::where('department_name', $counselorData['department'])->first();

            $counselor = new Counselor([
                'first_name' => $counselorData['first_name'],
                'last_name' => $counselorData['last_name'],
                'email' => $counselorData['email'],
            ]);

            $counselor->user()->associate($user);
            $counselor->department()->associate($department);
            $counselor->save();
        }
    }
}
