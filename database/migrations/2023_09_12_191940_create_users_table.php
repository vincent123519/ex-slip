<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name', 50)->default('');
            $table->string('last_name', 50)->default('');
            $table->string('middle_name', 50)->nullable();
            $table->string('title', 10)->nullable();
            $table->string('username', 50)->default('');
            $table->string('password', 255); // Keep this as 'password'
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            // Define foreign key relationship
            $table->foreign('role_id')->references('role_id')->on('user_roles')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
