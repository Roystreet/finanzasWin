<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_book');
            $table->foreign('id_book')->references('id')->on('books');
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->text('url_contrato')->nullable();
            $table->text('url_baucher_old')->nullable();
            $table->text('url_baucher_new')->nullable();
            $table->text('url_certificado_old')->nullable();
            $table->text('url_certificado_new')->nullable();
            $table->text('url_traspado')->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('modified_by')->nullable();
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
        Schema::dropIfExists('files');
    }
}
