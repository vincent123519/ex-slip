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
                'email' => 'Jovelyn@gmail.com',
                'username' => 'jovelyn.Cuizon',
            ],
            [
                'first_name' => 'Dr. Anthony',
                'last_name' => 'Kilong',
                'school' => 'School of Engineering', // Update the school name
                'email' => 'Anthony@gmail.com',
                'username' => 'anthony.kilong',

            ],
            [
                'first_name' => 'Dr. Edgar',
                'last_name' => 'Detoya',
                'school' => 'School of Business Management', // Update the school name
                'email' => 'Detoyaa@gmail.com',
                'username' => 'edgar.detoya',

            ],
            [
                'first_name' => 'Dr. Marietta',
                'last_name' => 'Bongcales',
                'school' => 'School of Arts and Science', // Update the school name
                'email' => 'BongcalesM@gmail.com',
                'username' => 'Marietta.Bongcales',

            ],
            [
                'first_name' => 'Dr. Audrey',
                'last_name' => 'Verano',
                'school' => 'School of Allied Medical Science', // Update the school name
                'email' => 'AudreyM@gmail.com',
                'username' => 'Audrey.Verano',

            ],
            [
                'first_name' => 'Atty. Jonathan',
                'last_name' => 'Capanas',
                'school' => 'School of Law', // Update the school name
                'email' => 'JonathanC@gmail.com',
                'username' => 'Jonathan.Capanas',

            ],
            [
                'first_name' => 'Dr. Vinchita',
                'last_name' => 'Quinto',
                'school' => 'School of Education', // Update the school name
                'email' => 'Vinchita@gmail.com',
                'username' => 'Vinchita.Quinto',

            ],
        ];

        foreach ($deansData as $deanData) {
            // Find the user and school based on the provided IDs
            $user = User::create([
                'first_name' => $deanData['first_name'],
                'last_name' => $deanData['last_name'],
                'username' => $deanData['username'],
                'email' => $deanData['email'],
                'password' => Hash::make('12345'), // You can set a default password
                'role_id' => 5,
            ]);

            // Find the school
            $school = School::where('school_name', $deanData['school'])->first();

            // Create and save the dean
            $dean = new Dean([
                'first_name' => $deanData['first_name'],
                'last_name' => $deanData['last_name'],
                'email' => $deanData['email'],

            ]);

            $dean->user()->associate($user);
            $dean->school()->associate($school); // Change from department() to school()
            $dean->save();
        }
    }
}
