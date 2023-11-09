<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupportingDocument;
use App\Models\ExcuseSlip;
use Faker\Factory as Faker;

class SupportingDocumentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $excuseSlips = ExcuseSlip::pluck('excuse_slip_id')->all();

        foreach ($excuseSlips as $excuseSlipId) {
            $documentCount = $faker->numberBetween(2, 5);

            for ($i = 0; $i < $documentCount; $i++) {
                $document = new SupportingDocument();
                $document->excuse_slip_id = $excuseSlipId;
                $document->document_path = $faker->imageUrl();
                $document->upload_date = $faker->dateTimeBetween('-1 year', 'now');
                $document->save();
            }
        }
    }
}