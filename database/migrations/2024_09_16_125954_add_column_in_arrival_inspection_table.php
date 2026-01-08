<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInArrivalInspectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
        });
        Schema::connection('mdf')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
        });

        Schema::connection('mysql_test')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
        });

        Schema::connection('mysql2')->table('production_get_pass', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
        });
        Schema::connection('mdf')->table('production_get_pass', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
        });

        Schema::connection('mysql_test')->table('production_get_pass', function (Blueprint $table) {
            $table->string('driver_number')->nullable()->after('driver_name'); 
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
