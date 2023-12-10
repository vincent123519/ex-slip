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
            
            // Add any other columns you need for the StudyLoad table
            $table->timestamps();
        });
        
        Schema::create('study_load_course_offerings', function (Blueprint $table) {
            $table->unsignedBigInteger('study_load_id');
            $table->unsignedBigInteger('offer_code');
            
            $table->foreign('study_load_id')->references('studyload_id')->on('study_loads')->onDelete('cascade');
            $table->foreign('offer_code')->references('offer_code')->on('course_offerings')->onDelete('cascade');
            
            $table->primary(['study_load_id', 'offer_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_load_course_offerings');
        Schema::dropIfExists('study_loads');
    }
}