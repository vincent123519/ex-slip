<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dean;
use App\Models\User;
use App\Models\School;
use App\Models\Department;
use Faker\Factory as Faker;

class DeansSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Retrieve existing users, schools, and departments
        $users = User::all();
        $schools = School::all();
        $departments = Department::all();

        // Create sample deans
        $deans = [];
        $deanId = 10001; // Starting dean_id

        foreach ($users as $user) {
            $school = $schools->random();
            $department = $departments->random();

            $deans[] = [
                'dean_id' => $deanId,
                'user_id' => $user->user_id,
                'name' => $faker->name,
                'school_code' => $school->school_code,
                'department_id' => $department->department_id,
            ];

            $deanId++;
        }

        // Insert the deans into the database
        Dean::insert($deans);
    }
}