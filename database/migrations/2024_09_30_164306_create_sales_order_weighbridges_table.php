<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderWeighbridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::connection('mysql2')->create('sales_order_weighbridges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_no');
            $table->string('weighbridge_no');
            $table->string('weighbridge_userid');
            $table->string('gate_pass_no');
            $table->string('cosec_no')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('location_id')->nullable();
            $table->date('date');
            $table->string('consignee_weight');
            $table->string('vehicle_no');
            $table->string('customer_name');
            $table->decimal('gross_weight')->nullable();
            $table->string('crop_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('no_of_pkgs')->nullable();
            $table->string('goods_description')->nullable();
            $table->string('username')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::connection('mdf')->create('sales_order_weighbridges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_no');
            $table->string('weighbridge_no');
            $table->string('weighbridge_userid');
            $table->string('gate_pass_no');
            $table->string('cosec_no')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('location_id')->nullable();
            $table->date('date');
            $table->string('consignee_weight');
            $table->string('vehicle_no');
            $table->string('customer_name');
            $table->decimal('gross_weight')->nullable();
            $table->string('crop_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('no_of_pkgs')->nullable();
            $table->string('goods_description')->nullable();
            $table->string('username')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        // Schema::connection('mysql_test')->create('sales_order_weighbridges', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('so_no');
        //     $table->string('weighbridge_no');
        //     $table->string('weighbridge_userid');
        //     $table->string('gate_pass_no');
        //     $table->string('cosec_no')->nullable();
        //     $table->longText('description')->nullable();
        //     $table->tinyInteger('location_id')->nullable();
        //     $table->date('date');
        //     $table->string('consignee_weight');
        //     $table->string('vehicle_no');
        //     $table->string('customer_name');
        //     $table->decimal('gross_weight')->nullable();
        //     $table->string('crop_weight')->nullable();
        //     $table->string('net_weight')->nullable();
        //     $table->string('no_of_pkgs')->nullable();
        //     $table->string('goods_description')->nullable();
        //     $table->string('username')->nullable();
        //     $table->string('type')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('sales_order_weighbridges');
        Schema::connection('mdf')->dropIfExists('sales_order_weighbridges');
        Schema::connection('mysql_test')->dropIfExists('sales_order_weighbridges');
    }
}
