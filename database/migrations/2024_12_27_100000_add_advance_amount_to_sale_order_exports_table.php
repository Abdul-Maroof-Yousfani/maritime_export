<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvanceAmountToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add advance_amount column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_amount')) {
                $table->decimal('advance_amount', 15, 2)->default(0)->after('is_advance')->comment('Advance amount in PKR');
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
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_amount')) {
                $table->dropColumn('advance_amount');
            }
        });
    }
}
