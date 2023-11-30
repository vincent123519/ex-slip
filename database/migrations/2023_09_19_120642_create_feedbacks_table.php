<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
public function up()
{
Schema::create('feedback', function (Blueprint $table) {
$table->id('feedback_id');
$table->unsignedBigInteger('excuse_slip_id');
$table->string('feedback_remarks', 255);
$table->date('feedback_date');
$table->unsignedBigInteger('sender_id');
$table->string('feedback_type', 20); // Added feedback_type column

// Add foreign key constraints with the same data type
$table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips');
$table->foreign('sender_id')->references('user_id')->on('users');

// Add any other columns you need for the Feedback table
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('feedbacks');
}
}