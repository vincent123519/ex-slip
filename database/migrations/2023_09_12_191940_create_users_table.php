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
        $table->string('name', 100)->default('');
        $table->string('username', 50)->default('');
        $table->string('password', 255); // Keep this as 'password'
        $table->unsignedBigInteger('role_id')->default(1); // Set a default value
        $table->foreign('role_id')->references('role_id')->on('user_roles');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
