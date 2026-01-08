<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColumnsInSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function(Blueprint $table){
            $table->text('packing_view')->nullable();
            $table->text('quantity_view')->nullable();
            $table->text('unit_price_view')->nullable();
            $table->text('total_price_view')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function(Blueprint $table){
            $table->text('packing_view')->nullable();
            $table->text('quantity_view')->nullable();
            $table->text('unit_price_view')->nullable();
            $table->text('total_price_view')->nullable();
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
            $table->dropColumn('packing_view');
            $table->dropColumn('quantity_view');
            $table->dropColumn('unit_price_view');
            $table->dropColumn('total_price_view');
        });
        Schema::connection('mdf')->table('sale_order_exports', function(Blueprint $table){
            $table->dropColumn('packing_view');
            $table->dropColumn('quantity_view');
            $table->dropColumn('unit_price_view');
            $table->dropColumn('total_price_view');
        });
    }
}
