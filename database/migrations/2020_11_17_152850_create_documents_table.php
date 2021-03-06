<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number',50)->nullable();
            $table->string('document_name',255)->unique();
            $table->string('document_type',255)->default('Без типа');
            $table->json('document_area')->nullable();
            $table->integer('document_version')->default(0);
            $table->json('document_responsible_id');
            $table->integer('document_worker_id')->default(0);
            $table->json('document_signer_id');
            $table->json('document_tags')->nullable();
            $table->date('document_date_signing');
            $table->date('document_date_expired')->nullable();
            $table->json('document_data');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
