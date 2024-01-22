<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepartmentDegree;

class DepartmentDegreeSeeder extends Seeder
{
    public function run()
    {
        $degrees = [
            ['department_id' => 1, 'degree_name' => 'Bachelor of Science in Computer Science'],
            ['department_id' => 1, 'degree_name' => 'Bachelor of Science in Information Technology'],
            ['department_id' => 1, 'degree_name' => 'Bachelor of Science in Information System'],
            ['department_id' => 4, 'degree_name' => 'Bachelor of civil engineering'],
            ['department_id' => 2, 'degree_name' => 'Bachelor of electronic engineering'],
            // Add more sample degrees for other departments
        ];

        foreach ($degrees as $degree) {
            DepartmentDegree::updateOrCreate(
                ['department_id' => $degree['department_id'], 'degree_name' => $degree['degree_name']],
                $degree
            );
        }
    }
}