<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameOfShipperInBillOfLadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_bill_of_ladings', function (Blueprint $table) {
            $table->longText('name_of_shipper')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_bill_of_ladings', function (Blueprint $table) {
            $table->dropColumn('name_of_shipper');
        });
    }
}
