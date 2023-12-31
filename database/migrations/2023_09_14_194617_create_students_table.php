<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name', 100);
            $table->unsignedBigInteger('degree_id')->default(1); // Set a default value
            $table->unsignedBigInteger('year_level')->default(1);
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('degree_id')->references('degree_id')->on('department_degrees');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
