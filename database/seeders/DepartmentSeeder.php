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

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Seed the departments table with unique department_ids
        $schools = School::all();

        foreach ($schools as $school) {
            // Define departments for each school
            $departments = [];

            if ($school->school_code == 1001) {
                $departments = [
                    ['department_name' => 'School of Computer Studies'],
                ];
            } elseif ($school->school_code == 1002) {
                $departments = [
                    ['department_name' => 'Computer Engineering Department'],
                    ['department_name' => 'Electrical Engineering Department'],
                    ['department_name' => 'Civil Engineering Department'],
                    ['department_name' => 'Electronics Engineering Department'],
                    ['department_name' => 'Industrial Engineering Department'],
                    ['department_name' => 'Mechanical Engineering Department'],
                ];
            }
                elseif ($school->school_code == 1003) {
                    $departments = [
                    ['department_name' => 'Accountancy and Finance Department'],
                    ['department_name' => 'Business and Entrepreneurship Department'],
                    ['department_name' => 'Marketing And Human Resource Management Department'],
                    ['department_name' => 'Tourism and Hospitality Management Department'],
                    ];
                }
                elseif ($school->school_code == 1004) {
                        $departments = [
                    ['department_name' => 'Department of Psychology and Library Information Science'],
                    ['department_name' => 'Department of  Communication, Languages, and Literature'],
                    ['department_name' => 'Department of Mathematics and Sciences'],
                    ];
            }

            // Assign school code to each department
            foreach ($departments as &$department) {
                $department['school_code'] = $school->school_code;
            }

            // Insert departments for the specific school
            Department::insert($departments);
        }
    }
}
