<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger('excuse_slip_id');
            $table->text('feedback_remarks');
            $table->date('feedback_date');
            $table->unsignedBigInteger('sender_id');
            $table->string('feedback_type', 20);
            $table->timestamps();

            $table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips');
            $table->foreign('sender_id')->references('user_id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}