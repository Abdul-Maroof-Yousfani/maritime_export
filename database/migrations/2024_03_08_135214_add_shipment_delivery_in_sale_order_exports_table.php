<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipmentDeliveryInSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function(Blueprint $table){
            $table->text('shipment_delivery')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function(Blueprint $table){
            $table->text('shipment_delivery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function(Blueprint $table){
            $table->dropColumn('shipment_delivery');
        });
        Schema::connection('mdf')->table('sale_order_exports', function(Blueprint $table){
            $table->dropColumn('shipment_delivery');
        });
    }
}
