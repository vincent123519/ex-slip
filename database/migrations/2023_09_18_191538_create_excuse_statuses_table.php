<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcuseStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('excuse_statuses', function (Blueprint $table) {
            $table->id('status_id'); // Use 'id' as the primary key
            $table->string('status_name', 20)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('excuse_statuses');
    }
}
