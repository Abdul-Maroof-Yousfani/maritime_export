<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvanceReceivedStatusToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add advance_received_status column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_received_status')) {
                $table->tinyInteger('advance_received_status')->default(0)->after('advance_payment')->comment('0=Not Received, 1=Received');
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
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_received_status')) {
                $table->dropColumn('advance_received_status');
            }
        });
    }
}
