<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeansTable extends Migration
{
    public function up()
    {
        Schema::create('deans', function (Blueprint $table) {
            $table->id('dean_id'); // This will automatically create an auto-incrementing primary key 'dean_id'
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name', 100);
            $table->unsignedBigInteger('school_code')->nullable()->default(1001);
            $table->unsignedBigInteger('department_id')->default(1);

            // Add foreign key constraints with the same data type
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('school_code')->references('school_code')->on('schools');
            $table->foreign('department_id')->references('department_id')->on('departments');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deans');
    }
}