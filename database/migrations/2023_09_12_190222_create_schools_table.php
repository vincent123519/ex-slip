<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('school_code'); // Change 'increments' to 'unsignedBigInteger'
            $table->string('school_name', 100);
            $table->timestamps();
            
            // Set 'school_code' as the primary key
            $table->primary('school_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
