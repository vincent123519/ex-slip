<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselorsTable extends Migration
{
    public function up()
    {
        Schema::create('counselors', function (Blueprint $table) {
            $table->bigIncrements('counselor_id');
            $table->unsignedBigInteger('user_id')->unique(); // Change 'unsignedInteger' to 'unsignedBigInteger'
            $table->string('name', 100);
            $table->unsignedBigInteger('department_id'); // Change the data type to match departments
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('department_id')->references('department_id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('counselors');
    }
}
