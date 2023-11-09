<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyLoadsTable extends Migration
{
    public function up()
    {
        Schema::create('study_loads', function (Blueprint $table) {
            $table->increments('studyload_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id'); // Change to unsignedBigInteger
            $table->string('course_code', 10);
            $table->unsignedBigInteger('offer_code'); // Change to unsignedBigInteger to match course_offerings

            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
            $table->foreign('course_code')->references('course_code')->on('courses');
            $table->foreign('offer_code')->references('offer_code')->on('course_offerings'); // Change to match the data type

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_loads');
    }
}
