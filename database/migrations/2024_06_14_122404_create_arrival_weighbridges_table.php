<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalWeighbridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_weighbridges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('po_no');
            $table->unsignedBigInteger('weighbridge_no');
            $table->string('weighbridge_userid');
            $table->string('gate_pass_no');
            $table->string('inspection_no');
            $table->string('cosec_no')->nullable();
            $table->longText('description')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('consignee_weight');
            $table->text('shipment_origin');
            $table->string('vehicle_no');
            $table->string('customer_name');
            $table->decimal('first_weight')->nullable();
            $table->decimal('second_weight')->nullable();
            $table->decimal('gross_weight')->nullable();
            $table->decimal('amount_recived')->nullable();
            $table->string('no_of_pkgs')->nullable();
            $table->string('goods_description')->nullable();
            $table->string('username')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('arrival_weighbridges');
    }
}
