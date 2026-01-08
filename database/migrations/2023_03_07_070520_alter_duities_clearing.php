<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDuitiesClearing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_duties_clearings', function($table) {
            $table->integer('invoice_data_id')->after('invoice_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_duties_clearings', function (Blueprint $table) {
            $table->dropColumn(['invoice_data_id']);
        });
    }
}
