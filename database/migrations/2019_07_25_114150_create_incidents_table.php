<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
          $table->increments('id');
          $table->text('motive')->nullable();
          $table->integer('id_operator');
          $table->foreign('id_operator')->references('id')->on('operators');
          $table->boolean('appwifi')->nullable();
          $table->integer('id_brand');
          $table->foreign('id_brand')->references('id')->on('brands');
          $table->text('models')->nullable();
          $table->boolean('OS')->nullable();
          $table->text('verOS')->nullable();
          $table->timestamp('date_time')->nullable();
          $table->text('details')->nullable();
          $table->integer('modified_by')->nullable();
          $table->integer('created_by')->nullable();
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
          $table->boolean('status_system')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
