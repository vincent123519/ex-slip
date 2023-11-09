<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseOfferingsTable extends Migration
{
    public function up()
    {
        Schema::create('course_offerings', function (Blueprint $table) {
            // Define your primary key column here (offer_code in this case)
            $table->bigIncrements('offer_code');
            
            $table->string('course_code', 10);
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('teacher_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('days_of_week', 50);
            $table->unsignedBigInteger('department_id');

            $table->timestamps();

            $table->foreign('course_code')->references('course_code')->on('courses');
            $table->foreign('semester_id')->references('semester_id')->on('semesters');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers');
            $table->foreign('department_id')->references('department_id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_offerings');
    }
}
