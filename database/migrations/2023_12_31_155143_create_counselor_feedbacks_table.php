<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCounselorFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('counselor_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('excuse_slip_id');
            $table->unsignedBigInteger('counselor_id')->nullable(); // Allow NULL values
            $table->text('remarks');
            // Add other columns as needed

            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips');
            $table->foreign('counselor_id')->references('counselor_id')->on('counselors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('counselor_feedbacks');
    }
}