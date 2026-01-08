<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaintainenceJobIdColGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_passes', function (Blueprint $table) {
            $table->bigInteger('maintenance_job_id')->before('mo_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('gate_passes', function (Blueprint $table) {
            $table->dropColumn('maintenance_job_id');
        });
    }
}
