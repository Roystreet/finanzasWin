<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsQuotasDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments__quotas_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pay_quotas');
            $table->foreign('id_pay_quotas')->references('id')->on('payments_quotas');
            $table->date('date_emission');
            $table->text('letter')->nullable();
            $table->text('cod_voucher')->nullable();
            $table->integer('id_customer_pay');
            $table->foreign('id_customer_pay')->references('id')->on('customers');
            $table->date('date_limit');
            $table->date('date_expiration');
            $table->text('import')->nullable();
            $table->integer('id_pay');
            $table->foreign('id_pay')->references('id')->on('pays');
            $table->text('total_amount');
            $table->integer('id_money');
            $table->foreign('id_money')->references('id')->on('moneys');
            $table->text('amount_dolar');
            $table->text('note')->nullable();
            $table->integer('modified_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('status_system')->nullable()->default(true);
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
        Schema::dropIfExists('payments__quotas_ds');
    }
}
