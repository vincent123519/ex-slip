<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseExcuseSlipTable extends Migration
{
    public function up()
    {
        Schema::create('course_excuse_slip', function (Blueprint $table) {
            $table->unsignedBigInteger('excuse_slip_id');
            $table->unsignedBigInteger('offer_code');
            $table->boolean('is_remark_by_teacher')->default(false);
            $table->text('teacher_feedback')->nullable(); // To store feedback from the teacher
            
            // Foreign key constraints
            $table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips')->onDelete('cascade');
            $table->foreign('offer_code')->references('offer_code')->on('course_offerings')->onDelete('cascade');
            
            // Composite primary key
            $table->primary(['excuse_slip_id', 'offer_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_excuse_slip');
    }
}