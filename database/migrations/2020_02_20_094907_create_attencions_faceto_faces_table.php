<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttencionsFacetoFacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attencions_faceto_faces', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nro_ticket')->nullable();
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->integer('id_type_requirements');
            $table->foreign('id_type_requirements')->references('id')->on('type_requirements');
            $table->integer('id_type_customer');
            $table->integer('id_status_att');
            $table->foreign('id_status_att')->references('id')->on('status_ts');
            $table->foreign('id_type_customer')->references('id')->on('customer_types');
            $table->timestamp('date_attencions')->nullable();
            $table->timestamp('date_resolve_attencions')->nullable();
            $table->integer('asignated_to')->nullable();
            $table->integer('nro_modulo')->nullable();
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
        Schema::dropIfExists('attencions_faceto_faces');
    }
}
