<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
          $table->increments('id');
          $table->string('action_bitacora');
          $table->string('database_modification');
          $table->string('column_table');
          $table->string('fact_column_before');
          $table->string('fact_column_after');
          $table->integer('id_user');
          $table->string('ip');
          $table->string('location_modification');
          $table->timestamp('date_modification')->nullable();
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacoras');
    }
}
