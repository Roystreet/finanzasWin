<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberBookSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_book_saves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_book');
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
        Schema::dropIfExists('number_book_saves');
    }
}