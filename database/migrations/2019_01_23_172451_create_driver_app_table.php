<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_app', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dblink_driver')    ->unique();
            $table->text('license_number')->unique()->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('dni')      ->unique()->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->integer('id_country')->unsigned();
            $table->foreign('id_country')->references('id')->on('country');

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
        Schema::dropIfExists('driver_app');
    }
}
