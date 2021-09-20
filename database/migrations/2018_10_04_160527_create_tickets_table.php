<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod_ticket');
            $table->integer('id_customer');
            $table->integer('id_invited_by');
            $table->integer('id_country_invert');
            $table->integer('number_operation');
            $table->date('date_pay');
            $table->integer('id_pay');
            $table->foreign('id_pay')->references('id')->on('pays');
            $table->string('total');
            $table->integer('id_bank')->references('id')->on('bank');

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('modified_by')->nullable()->default('1');
            $table->integer('create_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->integer('status_user'  )->nullable()->default(2);
            $table->text('note')->nullable();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
