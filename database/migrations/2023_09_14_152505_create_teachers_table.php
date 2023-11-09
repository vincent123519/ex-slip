<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id'); // Use 'id' as the primary key
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name', 100);
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('department_id')->references('department_id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
