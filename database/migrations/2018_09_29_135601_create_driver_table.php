<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
          $table->increments('id');
          $table->text('name');
          $table->text('lastname');
          $table->integer('dni')    ->unique();
          $table->text('address');
          $table->text('phone');
          $table->text('email');
          $table->text('gender');
          $table->date('birthdate');

          
          $table->integer('id_nationality')->unsigned();
          $table->foreign('id_nationality')->references('id')->on('country');
          $table->integer('id_city_driver')->unsigned();
          $table->foreign('id_city_driver')->references('id')->on('city');
          $table->integer('id_country_address')->unsigned();
          $table->foreign('id_country_address')->references('id')->on('country');
          $table->integer('id_state_address')->unsigned();
          $table->foreign('id_state_address')->references('id')->on('state');
          $table->integer('id_city_address')->unsigned();
          $table->foreign('id_city_address')->references('id')->on('city');
          $table->text('note')->nullable();
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
          $table->integer('modified_by')->nullable()->default('1');
          $table->boolean('status_system')->nullable()->default(true);
          $table->boolean('status_user'  )->nullable()->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
}
