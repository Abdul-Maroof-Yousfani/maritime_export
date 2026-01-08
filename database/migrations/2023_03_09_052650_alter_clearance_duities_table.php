<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClearanceDuitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_duties_clearings', function($table) {
            $table->integer('fumigation_status')->after('status')->default(0);
            $table->integer('origin_status')->after('status')->default(0);
            $table->integer('clearance_status')->after('status')->default(0);
            $table->integer('quality_declear_status')->after('status')->default(0);
            $table->integer('quality_packing_status')->after('status')->default(0);
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
            $table->dropColumn(['fumigation_status','origin_status','clearance_status','quality_declear_status','quality_packing_status']);
        });
    }
}
