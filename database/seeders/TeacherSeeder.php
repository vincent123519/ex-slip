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
            ['first_name' => 'John Leeroy', 'last_name' => 'Gadiane', 'username' => 'John.Leeroy', 'department' => 'School of Computer Studies'],
            ['first_name' => 'Gene', 'last_name' => 'Abello', 'username' => 'Gene.Abello', 'department' => 'School of Computer Studies'],
            // Add more teachers as needed
        ];

        foreach ($teachers as $teacherData) {
            // Create a user with a username and set a default password
            $user = User::create([
                'first_name' => $teacherData['first_name'],
                'last_name' => $teacherData['last_name'],
                'username' => $teacherData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 2, // Replace 2 with the actual role ID for teachers
            ]);

            $department = Department::where('department_name', $teacherData['department'])->first();

            $teacher = new Teacher([
                // Adjust the attributes as needed
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                // Add other teacher attributes if needed
            ]);

            $teacher->user()->associate($user);
            $teacher->department()->associate($department);
            $teacher->save();
        }
    }
}
