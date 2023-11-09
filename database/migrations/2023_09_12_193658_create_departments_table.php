<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->default(1000); // Set a default value (e.g., 1000)
            $table->string('department_name', 100);
            $table->unsignedBigInteger('school_code');
            
            // Add foreign key constraints with the same data type
            $table->foreign('school_code')->references('school_code')->on('schools');
            $table->timestamps();
            
            // Set 'department_id' as the primary key
            $table->primary('department_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}

