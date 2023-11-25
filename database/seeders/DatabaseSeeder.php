<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DeansSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\SchoolSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\FeedbackSeeder;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\CounselorSeeder;
use Database\Seeders\StudyLoadSeeder;
use Database\Seeders\UserRolesSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\ExcuseSlipSeeder;
use Database\Seeders\ExcuseStatusSeeder;
use Database\Seeders\HeadCounselorSeeder;
use Database\Seeders\CourseOfferingSeeder;
use Database\Seeders\DepartmentDegreeSeeder;
use Database\Seeders\SupportingDocumentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // BachelorDegreeSeeder::class,
            SchoolSeeder::class,
            UserRolesSeeder::class,
            UsersSeeder::class,
            DepartmentSeeder::class,
            HeadCounselorSeeder::class,
            DepartmentDegreeSeeder::class,
            TeacherSeeder::class,
            CounselorSeeder::class,
            DeansSeeder::class,
            StudentSeeder::class,
            SemesterSeeder::class,
            CourseSeeder::class,
            CourseOfferingSeeder::class,
            ExcuseStatusSeeder::class,
            ExcuseSlipSeeder::class,
            FeedbackSeeder::class,
            SupportingDocumentSeeder::class,
            StudyLoadSeeder::class




        ]);
    }
}
