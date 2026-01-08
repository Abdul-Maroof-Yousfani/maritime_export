<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInIssuanceData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('issuance_data', function (Blueprint $table) {
            $table->integer('replace_qty')->default(0);
        });
        Schema::connection('mdf')->table('issuance_data', function (Blueprint $table) {
            $table->integer('replace_qty')->default(0);
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
