<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data from the table
        Department::truncate();

        // Seed the departments table with unique department_ids
        $schools = School::all();
        $departmentId = 1; // Initialize the department_id counter

        foreach ($schools as $school) {
            Department::create([
                'department_id' => $departmentId++, // Increment the department_id
                'department_name' => 'Department 1',
                'school_code' => $school->school_code,
            ]);

            Department::create([
                'department_id' => $departmentId++, // Increment the department_id
                'department_name' => 'Department 2',
                'school_code' => $school->school_code,
            ]);

            // Add more departments if needed
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
