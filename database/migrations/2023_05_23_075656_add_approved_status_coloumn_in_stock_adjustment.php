<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedStatusColoumnInStockAdjustment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('stock_adjustments', function (Blueprint $table) {
            $table->string('approve_username')->nullable();
            $table->boolean('approve_status')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('stock_adjustments', function (Blueprint $table) {
            $table->dropColumn('approve_username');
            $table->dropColumn('approve_status');
        });
    }
}
