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
            // Add more sample degrees for other departments
        ];

        foreach ($degrees as $degree) {
            DepartmentDegree::create($degree);
        }
    }
}
