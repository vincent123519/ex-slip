<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyIdToSemestersTable extends Migration
{
    public function up()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->string('sy_id');
            $table->foreign('sy_id')->references('sy_id')->on('school_years');
        });
    }

    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropForeign(['sy_id']);
            $table->dropColumn('sy_id');
        });
    }
}