<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvanceTypeToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_type')) {
                $table->string('advance_type')->nullable()->after('advance_payment');
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
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'advance_type')) {
                $table->dropColumn('advance_type');
            }
        });
    }
}

