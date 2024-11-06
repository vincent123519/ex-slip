<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcuseSlipsTable extends Migration
{
    public function up()
    {
        Schema::create('excuse_slips', function (Blueprint $table) {
            $table->id('excuse_slip_id'); // Primary key
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('dean_id');
            $table->text('reason');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('status_id');
            $table->boolean('read_by_counselor')->default(false);
            $table->boolean('read_by_dean')->default(false);
            $table->boolean('read_by_teacher')->default(false);
            $table->boolean('read_by_student')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('counselor_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('dean_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('status_id')->on('excuse_statuses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excuse_slips');
    }
}