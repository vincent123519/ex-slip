<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $this->call(DepartmentSeeder::class);

        $teachers = [
            ['user_id' => 1001, 'name' => 'Mr. John Leeroy Gadiane', 'username' => 'John.Leeroy','department' => 'Information Techonology Department'],
            ['user_id' => 1002, 'name' => 'Mr. Gene Abello','username' => 'John.Leeroy','department' => 'Information Techonology Department'],
            // Add more teachers as needed
        ];

        foreach ($teachers as $teacherData) {

            $user = User::create([
                'name' => $teacherData['name'],
                'username' => $teacherData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 2,
            ]);

            $department = Department::where('department_name', $teacherData['department'])->first();



                $teacher = new Teacher([
                    'name' => $teacherData['name'],
                ]);

                $teacher->user()->associate($user);
                $teacher->department()->associate($department);
                $teacher->save();
            
        }

    }
}
