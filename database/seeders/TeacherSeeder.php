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
        $teachersData = [
            ['user_id' => 1001, 'name' => 'Mr. John Leeroy Gadiane'],
            ['user_id' => 1002, 'name' => 'Mr. Gene Abello'],
            // Add more teachers as needed
        ];

        foreach ($teachersData as $teacherData) {
            $user = User::find($teacherData['user_id']);

            if ($user) {
                $teacher = new Teacher([
                    'name' => $teacherData['name'],
                ]);

                $teacher->user()->associate($user);
                $teacher->department()->associate(Department::find(1)); // Assuming department_id is 1
                $teacher->save();
            }
        }

        // After creating teachers, run the CourseOfferingSeeder
        $this->call(CourseOfferingSeeder::class);
    }
}
