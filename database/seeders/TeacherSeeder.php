<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Department;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            ['user_id' => 1001, 'name' => 'John Doe', 'department_id' => 2001],
            ['user_id' => 1002, 'name' => 'Jane Smith', 'department_id' => 2001],
            // Add more sample teachers
        ];

        foreach ($teachers as $teacherData) {
            $user = User::find($teacherData['user_id']);
            $department = Department::find($teacherData['department_id']);

            if ($user && $department) {
                $teacher = new Teacher([
                    'name' => $teacherData['name'],
                ]);

                $teacher->user()->associate($user);
                $teacher->department()->associate($department);
                $teacher->save();
            }
        }
    }
}