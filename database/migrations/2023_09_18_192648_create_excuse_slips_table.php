<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcuseSlipsTable extends Migration
{
    public function up()
    {
        Schema::create('excuse_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('dean_id');
            $table->unsignedBigInteger('offer_code'); // Updated to match the data type of the offer_code column in course_offerings
            $table->text('reason');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('teacher_id')->references('teacher_id')->on('course_offerings');
            $table->foreign('counselor_id')->references('department_id')->on('department_degrees');
            $table->foreign('dean_id')->references('department_id')->on('department_degrees');
            $table->foreign('offer_code')->references('offer_code')->on('course_offerings');
            $table->foreign('status_id')->references('status_id')->on('excuse_statuses');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excuse_slips');
    }
}