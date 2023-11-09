<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['role_name' => 'Head Counselor', 'role_description' => 'Head Counselor'],
            ['role_name' => 'Teacher', 'role_description' => 'Teacher'],
            ['role_name' => 'Student', 'role_description' => 'Student'],
            ['role_name' => 'Counselor', 'role_description' => 'Counselor'],
            ['role_name' => 'Dean', 'role_description' => 'Dean'],
            // Add more sample data here
        ];

        UserRole::insert($roles);
    }
}