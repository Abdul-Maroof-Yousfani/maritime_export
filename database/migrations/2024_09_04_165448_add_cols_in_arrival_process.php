<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsInArrivalProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('po_no')->nullable();
            $table->string('recived_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
        });
        Schema::connection('mdf')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('po_no')->nullable();
            $table->string('recived_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
        });
        Schema::connection('mysql_test')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('po_no')->nullable();
            $table->string('recived_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
        });

        Schema::connection('mysql2')->table('production_get_pass', function (Blueprint $table) {
            $table->renameColumn('get_pass_type', 'type');
        });

        Schema::connection('mdf')->table('production_get_pass', function (Blueprint $table) {
            $table->renameColumn('get_pass_type', 'type');
        });
        Schema::connection('mysql_test')->table('production_get_pass', function (Blueprint $table) {
            $table->renameColumn('get_pass_type', 'type');
        });

        Schema::connection('mysql2')->table('arrival_weighbridges', function (Blueprint $table) {
             $table->string('type')->nullable();
        });

        Schema::connection('mdf')->table('arrival_weighbridges', function (Blueprint $table) {
             $table->string('type')->nullable();
        });
        Schema::connection('mysql_test')->table('arrival_weighbridges', function (Blueprint $table) {
             $table->string('type')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
