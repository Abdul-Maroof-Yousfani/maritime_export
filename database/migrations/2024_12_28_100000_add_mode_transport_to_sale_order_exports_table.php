<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeTransportToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add mode_transport column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'mode_transport')) {
                $table->integer('mode_transport')->nullable()->after('incoterm');
            }
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
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'mode_transport')) {
                $table->dropColumn('mode_transport');
            }
        });
    }
}
