<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\ExcuseSlip;
use App\Models\User;
use Faker\Factory as Faker;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $excuseSlips = ExcuseSlip::pluck('excuse_slip_id')->all();
        $users = User::pluck('user_id')->all();
        $feedbackTypes = ['Positive', 'Negative', 'Neutral'];

        foreach ($excuseSlips as $excuseSlipId) {
            $feedbackCount = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $feedbackCount; $i++) {
                $feedback = new Feedback();
                $feedback->excuse_slip_id = $excuseSlipId;
                $feedback->feedback_remarks = $faker->sentence;
                $feedback->feedback_date = $faker->date();
                $feedback->sender_id = $faker->randomElement($users);

                // Ensure the feedback type does not exceed 20 characters
                $feedbackType = $faker->randomElement($feedbackTypes);
                $feedback->feedback_type = substr($feedbackType, 0, 20);

                $feedback->save();
            }
        }
    }
}