<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableArrivalWeighbridgesChangeWeighbridgeNoColomnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->string('weighbridge_no')->change();
            $table->string('po_no')->change();
        });
        Schema::connection('mdf')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->string('weighbridge_no')->change();
            $table->string('po_no')->change();
        });
        Schema::connection('mysql_test')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->string('weighbridge_no')->change();
            $table->string('po_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arrival_weighbridges', function (Blueprint $table) {
            Schema::connection('mysql2')->table('arrival_weighbridges', function (Blueprint $table) {
                $table->string('weighbridge_no')->change();
                $table->string('po_no')->change();
            });
            Schema::connection('mdf')->table('arrival_weighbridges', function (Blueprint $table) {
                $table->string('weighbridge_no')->change();
                $table->string('po_no')->change();
            });
            Schema::connection('mysql_test')->table('arrival_weighbridges', function (Blueprint $table) {
                $table->string('weighbridge_no')->change();
                $table->string('po_no')->change();
            });
        });
    }
}
