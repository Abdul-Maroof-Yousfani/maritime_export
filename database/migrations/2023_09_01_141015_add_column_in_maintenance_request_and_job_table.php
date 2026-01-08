<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInMaintenanceRequestAndJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function ($table) {
            $table->biginteger('warehouse_id_to')->nullable();
        });
        Schema::connection('mdf')->table('maintenance_jobs', function ($table) {
            $table->biginteger('warehouse_id_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function ($table) {
            $table->dropColumn('warehouse_id_to');
        });
        Schema::connection('mdf')->table('maintenance_jobs', function ($table) {
            $table->dropColumn('warehouse_id_to');
        });
    }
}
