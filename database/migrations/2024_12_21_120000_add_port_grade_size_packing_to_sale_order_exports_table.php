<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPortGradeSizePackingToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'port')) {
                $table->integer('port')->nullable()->after('origin');
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'grade')) {
                $table->integer('grade')->nullable()->after('port_loading');
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'size')) {
                $table->integer('size')->nullable()->after('grade');
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'packing')) {
                $table->integer('packing')->nullable()->after('size');
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'consignee')) {
                $table->integer('consignee')->nullable()->after('packing');
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
            $table->dropColumn(['port', 'grade', 'size', 'packing', 'consignee']);
        });
    }
}


