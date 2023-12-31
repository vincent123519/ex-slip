<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounselorFeedbackSeeder extends Seeder
{
    public function run()
    {
        // Seed some sample data for testing
        DB::table('counselor_feedbacks')->insert([
            [
                'excuse_slip_id' => 1, // Replace with actual excuse_slip_id
                'counselor_id' => 1,  // Replace with actual counselor_id
                'remarks' => 'This is a sample feedback.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}
