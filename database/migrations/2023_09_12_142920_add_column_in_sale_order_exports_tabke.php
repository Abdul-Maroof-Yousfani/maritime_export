<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInSaleOrderExportsTabke extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function ($table) {
            $table->date('delevery_date_to')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function ($table) {
            $table->date('delevery_date_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function ($table) {
            $table->dropColumn('delevery_date_to');
        });
        Schema::connection('mdf')->table('sale_order_exports', function ($table) {
            $table->dropColumn('delevery_date_to');
        });
    }
}
