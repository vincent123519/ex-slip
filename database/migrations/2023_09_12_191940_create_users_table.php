<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Use 'id' instead of 'unsignedBigInteger' to set it as primary key
            $table->string('name', 100)->default('');
            $table->string('username', 50)->default('');
            $table->string('password_hash', 255);
            $table->unsignedInteger('role_id')->default(3); // Default role for students
            $table->foreign('role_id')->references('role_id')->on('user_roles');
            // Add any other columns you need for the Users table

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
