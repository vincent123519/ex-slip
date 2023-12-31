<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportingDocumentsTable extends Migration
{
public function up()
{
Schema::create('supporting_documents', function (Blueprint $table) {
$table->id('document_id');
$table->unsignedBigInteger('excuse_slip_id');
$table->string('document_path', 255);
$table->timestamp('upload_date'); // Changed to timestamp

// Add foreign key constraints with the same data type
$table->foreign('excuse_slip_id')->references('excuse_slip_id')->on('excuse_slips');

// Add any other columns you need for the SupportingDocuments table
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('supporting_documents');
}
}