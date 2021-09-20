<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->text('bono_directo');
            $table->date('fecha_cobro');
            $table->integer('modo_pago');
            $table->integer('tip_moneda');
            $table->text('observaciones');
            $table->text('obser_int');
            $table->integer('id_ticket');
            $table->integer('id_user_register');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('modified_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->boolean('status_user'  )->nullable()->default(true);
            $table->text('note')->nullable();
            $table->foreign('id_ticket')->references('id')->on('tickets');
            $table->foreign('modo_pago')->references('id')->on('pays');
            $table->foreign('tip_moneda')->references('id')->on('moneys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_payments');
    }
}
