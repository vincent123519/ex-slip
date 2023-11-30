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
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => 'admin123', // Password will be hashed automatically in the User model
                'role_id' => $adminRoleId,
            ],
            [
                'user_id' => 2,
                'name' => 'Teacher User',
                'username' => 'teacher',
                'password' => 'teacher123',
                'role_id' => $teacherRoleId,
            ],
            [
                'user_id' => 1001,
                'name' => 'John Doe',
                'username' => 'john.doe',
                'password' => 'password', // Set a default password (will be hashed automatically)
                'role_id' => $studentRoleId,
            ],
            // Add more users here
        ];

        foreach ($users as $userData) {
            // Use the User model to create a new user
            $user = User::updateOrCreate(['user_id' => $userData['user_id']], $userData);
        
            // Hash the password if it's provided
            if (isset($userData['password'])) {
                $user->password = Hash::make($userData['password']);
                $user->save();
            }
        }
    }
}
