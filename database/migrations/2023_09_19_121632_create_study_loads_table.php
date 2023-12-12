<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyLoadsTable extends Migration
{
    public function up()
    {
        Schema::create('study_loads', function (Blueprint $table) {
            $table->id('studyload_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('offer_code');
    
            // Add foreign key constraints with the same data type
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
            $table->foreign('offer_code')->references('offer_code')->on('course_offerings');
    
            // Add any other columns you need for the StudyLoad table
            $table->timestamps();
        });
    }
    


public function down()
{
Schema::dropIfExists('study_loads');
}
}