<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExportDutiesClearings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::connection('mysql2')->table('export_duties_clearings', function($table) {
            $table->integer('status')->after('lifting_charges')->default(0);
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
            $table->dropColumn(['status']);
        });
    }
}
