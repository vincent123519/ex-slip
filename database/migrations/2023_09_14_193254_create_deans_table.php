<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeansTable extends Migration
{
    public function up()
    {
        Schema::create('deans', function (Blueprint $table) {
            $table->unsignedBigInteger('dean_id'); // Change 'increments' to 'unsignedBigInteger'
            $table->unsignedBigInteger('user_id')->unique(); // Change 'unsignedInteger' to 'unsignedBigInteger'
            $table->string('name', 100);
            $table->unsignedBigInteger('school_code');
            $table->unsignedBigInteger('department_id');
            
            // Add foreign key constraints with the same data type
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('school_code')->references('school_code')->on('schools');
            $table->foreign('department_id')->references('department_id')->on('departments');
            
            // Set 'dean_id' as the primary key
            $table->primary('dean_id');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deans');
    }
}
