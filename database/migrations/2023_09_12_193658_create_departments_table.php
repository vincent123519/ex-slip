<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id'); // Set a default value (e.g., 1000)
            $table->string('department_name', 100);
            $table->unsignedBigInteger('school_code');
            
            // Add foreign key constraints with the same data type
            $table->foreign('school_code')->references('school_code')->on('schools');
            $table->timestamps();
            
          
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}

