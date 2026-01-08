<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInGatepassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_passes', function (Blueprint $table) {
            $table->boolean('is_complete')->default(0)->comment('0 => not complete, 1 => complete');
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
            $table->dropColumn('is_complete');
        });
    }
}
