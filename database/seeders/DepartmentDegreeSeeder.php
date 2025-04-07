<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentDegree;
use App\Enums\DegreeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentDegreeSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data from the table
        DepartmentDegree::truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Define department degrees for each department using department names
        $departmentsDegrees = [
            'School of Computer Studies' => [
                DegreeEnum::BSCS->label(),
                DegreeEnum::BSIT->label(),
                DegreeEnum::BSIS->label(),
            ],
            'Computer Engineering Department' => [
                DegreeEnum::BSCPE->label(),
            ],
            'Electrical Engineering Department' => [
                DegreeEnum::BSEE->label(),
            ],
            'Civil Engineering Department' => [
                DegreeEnum::BSCE->label(),
            ],
            'Electronics Engineering Department' => [
                DegreeEnum::BSECE->label(),
            ],
            'Industrial Engineering Department' => [
                DegreeEnum::BSIE->label(),
            ],
            'Mechanical Engineering Department' => [
                DegreeEnum::BSME->label(),
            ],
            'Accountancy and Finance Department' => [
                DegreeEnum::BSA->label(),
            ],
            'Business and Entrepreneurship Department' => [
                DegreeEnum::BSENT->label(),
            ],
            'Marketing And Human Resource Management Department' => [
                DegreeEnum::BSBA_MM->label(),
                DegreeEnum::BSBA_FM->label(),
                DegreeEnum::BSBA_HRM->label(),
            ],
            'Tourism and Hospitality Management Department' => [
                DegreeEnum::BSHM->label(),
                DegreeEnum::BSHMFB->label(),
                DegreeEnum::BSTM->label(),
            ],
            'Department of Psychology and Library Information Science' => [
                DegreeEnum::BSPSYC->label(),
            ],
            'Department of Communication, Languages, and Literature' => [
                DegreeEnum::BAJOUR->label(),
                DegreeEnum::BACOM->label(),
            ],
            'Department of Mathematics and Sciences' => [
                DegreeEnum::BSMATH->label(),
            ],
            'Medical Technology Department' => [
                DegreeEnum::BSMLS->label(),
            ],
            'Nursing Department' => [
                DegreeEnum::BSN->label(),
            ],
            'Law Regular Program' => [
                DegreeEnum::BAPOS->label(),
            ],
            'Education Departments' => [
                DegreeEnum::BEED->label(),
                DegreeEnum::BECED->label(),
                DegreeEnum::BPED->label(),
                DegreeEnum::BSEd_ENGLISH->label(),
                DegreeEnum::BSEd_FILIPINO->label(),
                DegreeEnum::BSEd_MATH->label(),
                DegreeEnum::BSEd_SCIENCE->label(),
                DegreeEnum::BSNE_EST->label(),
                DegreeEnum::BSNE_GEN->label(),
            ],
            'Philosophy and Arts Departments' => [
                DegreeEnum::PHILO->label(),
                DegreeEnum::ABIS->label(),
                DegreeEnum::BAELS->label(),
                DegreeEnum::BLIS->label(),
            ]
        ];

        // Insert department degrees for each department
        foreach ($departmentsDegrees as $departmentName => $degreeNames) {
            // Get the department_id based on the department name
            $department = Department::where('department_name', $departmentName)->first();

            if ($department) {
                foreach ($degreeNames as $degreeName) {
                    // Insert department degree into the table
                    DepartmentDegree::updateOrCreate(
                        ['department_id' => $department->department_id, 'degree_name' => $degreeName],
                        ['degree_name' => $degreeName, 'department_id' => $department->department_id]
                    );
                }
            }
        }
    }
}
