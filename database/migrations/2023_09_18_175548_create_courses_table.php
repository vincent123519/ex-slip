<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('course_code', 10)->primary();
            $table->string('course_name', 100);
            $table->unsignedBigInteger('department_id')->default(1); // Set a default department ID (e.g., 1)
            
            // Change the foreign key constraint to match the data type
            $table->foreign('department_id')->references('department_id')->on('departments');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
