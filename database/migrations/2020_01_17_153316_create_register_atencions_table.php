<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterAtencionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_atencions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->text('subject');
            $table->text('description');
            $table->integer('nro_ticket')->nullable();
            $table->timestamp('date_register')->nullable();
            $table->time('time_register')->nullable();
            $table->time('time_start_register')->nullable();
            $table->timestamp('due_by');
            $table->boolean('st_due_by');
            $table->timestamp('fr_due_by');
            $table->boolean('st_fr_due_by');
            $table->text('attachments')->nullable();
            $table->integer('id_type_requirements');
            $table->foreign('id_type_requirements')->references('id')->on('type_requirements');
            $table->integer('id_status_ts');
            $table->foreign('id_status_ts')->references('id')->on('status_ts');
            $table->integer('id_group');
            $table->foreign('id_group')->references('id')->on('groups_tickets');
            $table->text('ubication')->nullable();
            $table->integer('id_travel')->nullable();
            $table->integer('id_category')->nullable();
            $table->foreign('id_category')->references('id')->on('categories');
            $table->text('referenceubi')->nullable();
            $table->integer('id_priorities');
            $table->foreign('id_priorities')->references('id')->on('priorities');
            $table->integer('id_country');
            $table->foreign('id_country')->references('id')->on('country');
            $table->integer('id_type_customer');
            $table->foreign('id_type_customer')->references('id')->on('customer_types');
            $table->integer('age')->nullable();
            $table->text('placa')->nullable();
            $table->text('marca')->nullable();
            $table->text('model')->nullable();
            $table->text('color_car')->nullable();
            $table->integer('year')->nullable();
            $table->text('type_safe')->nullable();
            $table->text('enterprisesoat')->nullable();
            $table->text('type_soat')->nullable();
            $table->date('soatfecemi')->nullable();
            $table->date('soatfecven')->nullable();
            $table->text('motive')->nullable();
            $table->integer('id_operator')->nullable();
            $table->foreign('id_operator')->references('id')->on('operators');
            $table->boolean('appwifi')->nullable();
            $table->integer('id_brand')->nullable();
            $table->foreign('id_brand')->references('id')->on('brands');
            $table->text('models')->nullable();
            $table->boolean('OS')->nullable();
            $table->text('verOS')->nullable();
            $table->timestamp('date_time')->nullable();
            $table->text('details')->nullable();
            $table->integer('id_customer_ext')->nullable();
            $table->text('relationship')->nullable();
            $table->integer('age_ext')->nullable();
            $table->integer('id_type_customer_ext')->nullable();
            $table->integer('asignated_to')->nullable();
            $table->integer('type_servicedesk')->nullable();
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
        Schema::dropIfExists('register_atencions');
    }
}
