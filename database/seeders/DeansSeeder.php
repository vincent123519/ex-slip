<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dean;
use App\Models\School; // Import the School model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeansSeeder extends Seeder
{
    public function run()
    {
        // Retrieve existing users and schools
        $this->call(SchoolSeeder::class); // Assuming you have a SchoolSeeder

        // Create deans with existing user and school IDs
        $deansData = [
            [
                'first_name' => 'Dr. Jovelyn',
                'last_name' => 'Cuizon',
                'school' => 'School of Computer Studies',
                'username' => 'jovelyn.Cuizon',
            ],
            [
                'first_name' => 'Dr. Anthony',
                'last_name' => 'Kilong',
                'school' => 'School of Engineering', // Update the school name
                'username' => 'anthony.kilong',
            ],
            // Add more sample deans
        ];

        foreach ($deansData as $deanData) {
            // Find the user and school based on the provided IDs
            $user = User::create([
                'first_name' => $deanData['first_name'],
                'last_name' => $deanData['last_name'],
                'username' => $deanData['username'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 5,
            ]);

            // Find the school
            $school = School::where('school_name', $deanData['school'])->first();

            // Create and save the dean
            $dean = new Dean([
                'first_name' => $deanData['first_name'],
                'last_name' => $deanData['last_name'],
            ]);

            $dean->user()->associate($user);
            $dean->school()->associate($school); // Change from department() to school()
            $dean->save();
        }
    }
}
