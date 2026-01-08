<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInExportDataSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->string('bag_type')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->string('bag_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->dropColumn('bag_type')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->dropColumn('bag_type')->nullable();
        });
    }
}
