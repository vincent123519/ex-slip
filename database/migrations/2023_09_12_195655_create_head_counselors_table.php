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
            $table->string('name', 100);
            $table->unsignedBigInteger('department_id');
            
            // Add foreign key constraints with the same data type
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('department_id')->references('department_id')->on('departments');
            
            // Add any other columns you need for the HeadCounselors table
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('head_counselors');
    }
}
