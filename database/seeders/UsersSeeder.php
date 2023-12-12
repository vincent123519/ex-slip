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
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => Hash::make('12345'), // You can set a default password
        ];

        User::updateOrCreate(['username' => $adminUser['username']], $adminUser);
        
        // Add more users here
    }
}
