<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversSaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_saldo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_driver');
            $table->integer('id_pay');

            $table->integer('id_bank')->nullable();
            $table->integer('id_account_type')->nullable();
            $table->text('number_operation')->nullable();
            $table->timestamp('date_pay')->nullable();

            $table->timestamp('date_saldo')->nullable();
            $table->text('route_img')->unique()->nullable();
            $table->text('name_img')->unique()->nullable();

            $table->double('saldo_actual')->nullable();
            $table->double('saldo_recarga')->nullable();


            $table->foreign('id_pay'         )->references('id')->on('pays');
            $table->foreign('id_driver'      )->references('id')->on('driver_app');
            $table->foreign('id_bank'        )->references('id')->on('banks');
            $table->foreign('id_account_type')->references('id')->on('account_type');

            $table->text('note')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('modified_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->integer('status_user'  )->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers_saldo');
    }
}
