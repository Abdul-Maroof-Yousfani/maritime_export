<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGatepassreturnableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->string('company_location_id')->nullable();
        });

        Schema::connection('mysql2')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->string('company_location_id')->nullable();
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
