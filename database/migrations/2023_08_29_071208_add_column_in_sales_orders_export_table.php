<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInSalesOrdersExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->bigInteger('part_shipment')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->bigInteger('part_shipment')->nullable();
        });

        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->decimal('qty_variation')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->decimal('qty_variation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('part_shipment');
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('part_shipment');
        });

        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->dropColumn('qty_variation');
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->dropColumn('qty_variation');
        });
    }
}
