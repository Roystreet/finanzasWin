<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_tickets', function (Blueprint $table) {
          $table->increments('id');
          $table->text('description')->nullable();
          $table->text('idGroupFdesk')->nullable();
          $table->integer('id_rol')->nullable();
          $table->foreign('id_rol')->references('id')->on('roles');
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
        Schema::dropIfExists('groups_tickets');
    }
}
