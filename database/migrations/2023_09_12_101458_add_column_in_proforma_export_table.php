<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInProformaExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_performas', function ($table) {
            $table->string('pro_contract_no')->nullable();
        });
        Schema::connection('mdf')->table('export_performas', function ($table) {
            $table->string('pro_contract_no')->nullable();
        });
        //contract_no
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_performas', function ($table) {
            $table->dropColumn('pro_contract_no');
        });
        Schema::connection('mdf')->table('export_performas', function ($table) {
            $table->dropColumn('pro_contract_no');
        });

    }
}
