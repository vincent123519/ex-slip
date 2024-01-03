<?php

// In the create_teacher_feedbacks_table migration file

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('excuse_slip_id');
            $table->text('remarks');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
            $table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_feedbacks');
    }
}
