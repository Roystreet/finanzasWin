<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->text('cod_order')->unique();

            $table->date('date_pay')->nullable();
            $table->integer('id_pay')->nullable();
            $table->foreign('id_pay')->references('id')->on('pays');

            $table->integer('id_money')->nullable();
            $table->foreign('id_money')->references('id')->on('moneys');

            $table->double('total');
            $table->double('total_abono');      //deposito al conductor
            $table->double('total_ret');        //debito   al conductor


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
        Schema::dropIfExists('order_pay');
    }
}
