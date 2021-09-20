<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_product')->references('id')->on('product');
            $table->integer('id_money')->references('id')->on('moneys');
            $table->decimal('price',12,2);
            $table->text('description');
            $table->text('note');
            $table->integer('modified_by')->nullable()->default('1');
            $table->boolean('status_system')->nullable()->default(true);
            $table->integer('status_user' )->nullable()->default('1');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
