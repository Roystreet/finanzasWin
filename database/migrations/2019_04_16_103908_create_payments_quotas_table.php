<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_quotas', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_customer');
          $table->integer('id_ticket');
          $table->foreign('id_customer')->references('id')->on('customers');
          $table->foreign('id_ticket')->references('id')->on('tickets');
          $table->integer('quotas_amount')->nullable();
          $table->text('total_amount')->nullable();
          $table->text('frecuencia_payment')->nullable();
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
        Schema::dropIfExists('payments_quotas');
    }
}
