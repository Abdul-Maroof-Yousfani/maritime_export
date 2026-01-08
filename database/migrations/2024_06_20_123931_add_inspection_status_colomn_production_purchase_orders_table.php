<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInspectionStatusColomnProductionPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
            $table->tinyInteger('inspection_status')->default(0)->comment('1 first inspection , 2 second inspection')->after('voucher_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
            $table->tinyInteger('inspection_status')->default(0)->comment('1 first inspection , 2 second inspection')->after('voucher_status');
        });
    }
}
