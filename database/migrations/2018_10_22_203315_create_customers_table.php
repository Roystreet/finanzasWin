<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

              $table->increments('id');
              $table->text('first_name');
              $table->text('last_name');
              $table->text('document');
              $table->text('phone')->nullable();
              $table->text('email')->nullable();


              $table->integer('id_country')->nullable();
              $table->integer('id_state')->nullable();
              $table->integer('id_city')->nullable();

              $table->foreign('id_country')->references('id')->on('country');
              $table->foreign('id_state')->references('id')->on('state');
              $table->foreign('id_city')->references('id')->on('city');

              $table->text('address')->nullable();
              $table->dateTime('admission_date');
              $table->integer('invited_user')->nullable();

              $table->text('note')->nullable();
              $table->timestamp('created_at')->nullable();
              $table->timestamp('updated_at')->nullable();
              $table->integer('modified_by')->nullable()->default('1');
              $table->boolean('status_system')->nullable()->default(true);
              $table->integer('status_user'  )->nullable()->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
