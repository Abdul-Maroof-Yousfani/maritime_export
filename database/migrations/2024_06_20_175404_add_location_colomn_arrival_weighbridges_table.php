<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationColomnArrivalWeighbridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id');
        });
        Schema::connection('mdf')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id'); 
        });
        Schema::connection('mysql_test')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id');
        });
        Schema::connection('mdf')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id'); 
        });
        Schema::connection('mysql_test')->table('arrival_weighbridges', function (Blueprint $table) {
            $table->tinyInteger('location_id')->nullable()->after('customer_name');
            $table->string('location_no')->nullable()->after('location_id'); 
        });
    }
}
