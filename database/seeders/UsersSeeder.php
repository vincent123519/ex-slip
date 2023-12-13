<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Seed users
        $adminUser = [
            'first_name' => 'Admin User',
            'last_name' =>'user Admin',
            'username' => 'admin',
            'password' => Hash::make('12345'), // You can set a default password
            'role_id' => 6,
        ];

        User::updateOrCreate(['username' => $adminUser['username']], $adminUser);
        
        // Add more users here
    }
}
