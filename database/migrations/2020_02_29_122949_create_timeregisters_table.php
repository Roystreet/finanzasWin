<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeregistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeregisters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_att_face')->nullable();
            $table->integer('id_reg_att')->nullable();
            $table->timestamp('dt_create_module_attention')->nullable();
            $table->timestamp('dt_attended_module_attention')->nullable();
            $table->timestamp('dt_finished_module_attention')->nullable();
            $table->integer('module_agent_id')->nullable();
            $table->timestamp('dt_create_ticket_attention')->nullable();
            $table->timestamp('dt_attended_ticket_attention')->nullable();
            $table->timestamp('dt_finished_ticket_attention')->nullable();
            $table->integer('ticket_agent_id')->nullable();
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
        Schema::dropIfExists('timeregisters');
    }
}
