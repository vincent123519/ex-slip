<?php

// In the create_dean_feedbacks_table migration file

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeanFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('dean_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dean_id')->nullable();
            $table->unsignedBigInteger('excuse_slip_id');
            $table->text('remarks');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('dean_id')->references('dean_id')->on('deans')->onDelete('cascade');
            $table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dean_feedbacks');
    }
}
