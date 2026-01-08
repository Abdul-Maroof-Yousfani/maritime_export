<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInDemandDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('demand_data', function (Blueprint $table) {
            $table->boolean('cancel_status')->default(1);
        });
        Schema::connection('mdf')->table('demand_data', function (Blueprint $table) {
            $table->boolean('cancel_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('demand_data', function (Blueprint $table) {
            $table->dropColumn('cancel_status');
        });
        Schema::connection('mdf')->table('demand_data', function (Blueprint $table) {
            $table->dropColumn('cancel_status');
        });
    }
}
