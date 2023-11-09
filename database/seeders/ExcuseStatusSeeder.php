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
            ['status_id' => 2, 'status_name' => 'Approved'],
            ['status_id' => 3, 'status_name' => 'Rejected'],
            // Add more sample statuses here
        ];

        ExcuseStatus::insert($excuseStatuses);
    }
}