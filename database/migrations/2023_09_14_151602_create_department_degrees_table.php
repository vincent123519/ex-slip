<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentDegreesTable extends Migration
{
    public function up()
    {
        Schema::create('department_degrees', function (Blueprint $table) {
            $table->id('degree_id'); // Use 'id' with auto-increment
            $table->unsignedBigInteger('department_id'); // Change 'unsignedInteger' to 'unsignedBigInteger'
            $table->string('degree_name', 100);
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('department_degrees');
    }
}
