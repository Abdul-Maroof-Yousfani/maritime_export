<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('demand', function(Blueprint $table){
            $table->integer('demand_complete_status')->default(1)->after('demand_status')->comment('1 = Pending, 2 = Completed');
        });
        Schema::connection('mdf')->table('demand', function(Blueprint $table){
            $table->integer('demand_complete_status')->default(1)->after('demand_status')->comment('1 = Pending, 2 = Completed');
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
            $table->dropColumn('demand_complete_status');
        });
        Schema::connection('mdf')->table('demand', function(Blueprint $table){
            $table->dropColumn('demand_complete_status');
        });
    }
}
