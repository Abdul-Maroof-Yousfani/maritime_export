<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGateInIdColumnInGatepassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_passes', function(Blueprint $table){
            $table->bigInteger('gatepass_id')->nullable();
        });
        Schema::connection('mdf')->table('gate_passes', function(Blueprint $table){
            $table->bigInteger('gatepass_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('gate_passes', function(Blueprint $table){
            $table->dropColumn('gatepass_id');
        });
        Schema::connection('mdf')->table('gate_passes', function(Blueprint $table){
            $table->dropColumn('gatepass_id');
        });
    }
}
