<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPurchaseRequestDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('purchase_request_data', function(Blueprint $table){
            $table->integer('quotation_data_id')->default(0)->after('demand_data_id');
        });
        Schema::connection('mdf')->table('purchase_request_data', function(Blueprint $table){
            $table->integer('quotation_data_id')->default(0)->after('demand_data_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('purchase_request_data', function(Blueprint $table){
            $table->dropColumn('quotation_data_id');
        });
        Schema::connection('mdf')->table('purchase_request_data', function(Blueprint $table){
            $table->dropColumn('quotation_data_id');
        });
    }
}
