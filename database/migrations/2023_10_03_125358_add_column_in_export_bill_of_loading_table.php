<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInExportBillOfLoadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_bill_of_ladings', function ($table) {
            $table->longText('description')->nullable();
            $table->longText('consignee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_bill_of_ladings', function ($table) {
            $table->dropColumn('description');
            $table->dropColumn('consignee');
        });
    }
}
