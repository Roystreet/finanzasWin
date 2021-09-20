<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro_book')->nullable();
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->integer('cant')->nullable();
            $table->boolean('print_book')->nullable()->default(false);
            $table->integer('cant_print_book')->nullable()->default(0);
            $table->boolean('sign_book')->nullable()->default(false);
            $table->boolean('file_book')->nullable()->default(false);
            $table->integer('modified_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->boolean('status_system')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
