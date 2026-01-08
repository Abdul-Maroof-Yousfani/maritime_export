<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_order', function (Blueprint $table) {
            $table->string('ship_name')->nullable(); // Ship name
            $table->string('port_of_loading')->nullable(); // Port of Loading
            $table->string('port_of_discharge')->nullable(); // Port of Discharge
            $table->string('bill_of_landing')->nullable(); // Bill of Landing
            $table->date('bill_of_landing_date')->nullable(); // Bill of Landing Date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_order', function (Blueprint $table) {
            $table->dropColumn('ship_name');
            $table->dropColumn('port_of_loading');
            $table->dropColumn('port_of_discharge');
            $table->dropColumn('bill_of_landing');
            $table->dropColumn('bill_of_landing_date');
        });
    }
}
