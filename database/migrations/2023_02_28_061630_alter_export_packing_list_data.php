<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExportPackingListData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function($table) {
            $table->string('paking_list_upload_status')->after('brand')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function (Blueprint $table) {
            $table->dropColumn(['paking_list_upload_status']);
        });
    }
}
