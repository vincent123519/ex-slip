<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\ExcuseStatus;

class ExcuseStatusSeeder extends Seeder
{
    public function run()
    {
        $excuseStatuses = [
            ['status_id' => 1, 'status_name' => 'Pending'],
            ['status_id' => 2, 'status_name' => 'Approved by Counselor'],
            ['status_id' => 3, 'status_name' => 'Rejected'],
            ['status_id' => 4, 'status_name' => 'Approved by Dean'],
            ['status_id' => 5, 'status_name' => 'Approved by Teacher'],
            // Add more sample statuses here
        ];

        ExcuseStatus::insert($excuseStatuses);
    }
}