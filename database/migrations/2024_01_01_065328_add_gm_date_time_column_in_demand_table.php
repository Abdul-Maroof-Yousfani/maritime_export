<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGmDateTimeColumnInDemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('demand', function(Blueprint $table){
            $table->dateTime('gm_date_time')->nullable();
        });
        Schema::connection('mdf')->table('demand', function(Blueprint $table){
            $table->dateTime('gm_date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('demand', function(Blueprint $table){
            $table->dropColumn('gm_date_time');
        });
        Schema::connection('mdf')->table('demand', function(Blueprint $table){
            $table->dropColumn('gm_date_time');
        });
    }
}
