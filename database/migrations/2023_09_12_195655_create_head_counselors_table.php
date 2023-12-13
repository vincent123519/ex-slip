<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadCounselorsTable extends Migration
{
    public function up()
    {
        Schema::create('head_counselors', function (Blueprint $table) {
            $table->id('head_counselor_id'); // Use 'id' with auto-increment
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->unsignedBigInteger('department_id')->default(1); // Added department_id column

            // Add foreign key constraints with the same data type
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments'); // Assuming departments table has a department_id column

            // Add any other columns you need for the HeadCounselors table
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('head_counselors');
    }
}
