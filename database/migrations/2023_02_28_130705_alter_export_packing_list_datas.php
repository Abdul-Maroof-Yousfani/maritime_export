<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExportPackingListDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_paking_list_datas', function($table) {
            $table->integer('invoice_data_id')->after('import_paking_list_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_paking_list_datas', function (Blueprint $table) {
            $table->dropColumn(['invoice_data_id']);
        });
    }
}
