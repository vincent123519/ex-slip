<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcuseSlipsTable extends Migration
{
    public function up()
    {
        Schema::create('excuse_slips', function (Blueprint $table) {
            $table->id('excuse_slip_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('dean_id');
            $table->string('course_code', 50);
            $table->text('reason');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            // Modify foreign key constraints to match the Students table
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('teacher_id')->references('user_id')->on('users');
            $table->foreign('counselor_id')->references('user_id')->on('users');
            $table->foreign('dean_id')->references('user_id')->on('users');
            $table->foreign('course_code')->references('course_code')->on('courses');
            $table->foreign('status_id')->references('status_id')->on('excuse_statuses');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excuse_slips');
    }
}
