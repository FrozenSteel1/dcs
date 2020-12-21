<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('worker_name',50);
            $table->string('worker_surname',50);
            $table->string('worker_patronymic',50)->nullable();
            $table->string('worker_email',50)->nullable();
            $table->string('worker_email_spare',50)->nullable();
            $table->string('worker_tel',15)->nullable();
            $table->string('worker_tel_spare',15)->nullable();
            $table->string('division_id',255)->nullable();
            $table->string('worker_position',50)->nullable();
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
        Schema::dropIfExists('workers');
    }
}
