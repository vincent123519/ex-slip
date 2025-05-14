<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id('semester_id'); // Set 'semester_id' as an auto-incrementing primary key
            $table->string('semester_name', 50);
            $table->boolean('is_active')->default(false); // Add is_active column with default value false
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semesters');
    }
}