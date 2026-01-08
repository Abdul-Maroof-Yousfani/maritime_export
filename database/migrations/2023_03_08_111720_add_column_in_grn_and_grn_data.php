<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInGrnAndGrnData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function ($table) {
            $table->string('store_control_no')->nullable()->after('id');
        });
        Schema::connection('mysql2')->table('grn_data', function ($table) {
            $table->string('store_control_no')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function ($table) {
            $table->dropColumn('store_control_no');
        });
        Schema::connection('mysql2')->table('grn_data', function ($table) {
            $table->dropColumn('store_control_no');
        });
    }
}
