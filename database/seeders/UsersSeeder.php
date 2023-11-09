<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Seed user roles
        $roles = [
            ['role_name' => 'Admin', 'role_description' => 'Administrator'],
            ['role_name' => 'Teacher', 'role_description' => 'Teacher'],
            ['role_name' => 'Student', 'role_description' => 'Student'],
            ['role_name' => 'Counselor', 'role_description' => 'Counselor'],
            ['role_name' => 'Dean', 'role_description' => 'Dean'],
        ];

        foreach ($roles as $role) {
            UserRole::updateOrCreate(['role_name' => $role['role_name']], $role);
        }

        // Get role IDs
        $adminRoleId = UserRole::where('role_name', 'Admin')->value('role_id');
        $teacherRoleId = UserRole::where('role_name', 'Teacher')->value('role_id');
        $studentRoleId = UserRole::where('role_name', 'Student')->value('role_id');

        // Seed users
        $users = [
            [
                'user_id' => 1,
                'name' => 'admin',
                'username' => 'admin',
                'password_hash' => Hash::make('admin123'),
                'role_id' => $adminRoleId,
            ],
            [
                'user_id' => 2,
                'name' => 'teacher',
                'username' => 'teacher',
                'password_hash' => Hash::make('teacher123'),
                'role_id' => $teacherRoleId,
            ],
            [
                'user_id' => 1001,
                'name' => 'John Doe',
                'username' => 'john.doe',
                'password_hash' => Hash::make('password'), // Set a default password
                'role_id' => $studentRoleId,
            ],
            // Add more users here
        ];

        DB::table('users')->insert($users);
    }
}
