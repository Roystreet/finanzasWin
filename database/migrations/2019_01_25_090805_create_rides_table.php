<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dblink_ride')    ->unique();
            $table->integer('dblink_driver');

            $table->integer('id_driver');
            $table->foreign('id_driver')->references('id')->on('driver_app');

            $table->integer('id_status_pay');
            $table->foreign('id_status_pay')->references('id')->on('status_pay');


            $table->text('pay');
            $table->text('money');

            $table->date('date_ride');
            $table->double('total_pay');
            $table->double('porcentaj_ret');
            $table->double('mto_ret');
            $table->double('mto_abono');
            $table->text('status_app');

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
        Schema::dropIfExists('rides');
    }
}
