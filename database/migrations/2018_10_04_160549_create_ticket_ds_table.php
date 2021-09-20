<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ticket')->unsigned();
            $table->foreign('id_ticket')->references('id')->on('tickets');

            $table->integer('id_product');
            $table->foreign('id_product')->references('id')->on('products');

            $table->string('cant');
            $table->string('price');
            $table->integer('id_money');
            $table->foreign('id_money')->references('id')->on('moneys');
            $table->string('total');

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('modified_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->boolean('status_user'  )->nullable()->default(true);
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
        Schema::dropIfExists('ticket_ds');
    }
}
