<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['role_id' => 1, 'role_name' => 'Head Counselor', 'role_description' => 'Head Counselor'],
            ['role_id' => 2, 'role_name' => 'Teacher', 'role_description' => 'Teacher'],
            ['role_id' => 3, 'role_name' => 'Student', 'role_description' => 'Student'],
            ['role_id' => 4, 'role_name' => 'Counselor', 'role_description' => 'Counselor'],
            ['role_id' => 5, 'role_name' => 'Dean', 'role_description' => 'Dean'],
            // Add more sample data here
        ];

        UserRole::insert($roles);
    }
}
