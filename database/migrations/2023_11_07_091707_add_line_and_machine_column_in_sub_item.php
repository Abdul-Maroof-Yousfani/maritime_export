<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineAndMachineColumnInSubItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('subitem', function (Blueprint $table) {
            $table->bigInteger('line_id')->nullable();
            $table->bigInteger('machine_id')->nullable();
        });
        Schema::connection('mdf')->table('subitem', function (Blueprint $table) {
            $table->bigInteger('line_id')->nullable();
            $table->bigInteger('machine_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('subitem', function (Blueprint $table) {
            $table->dropColumn('line_id')->nullable();
            $table->dropColumn('machine_id')->nullable();
        });
        Schema::connection('mdf')->table('subitem', function (Blueprint $table) {
            $table->dropColumn('line_id')->nullable();
            $table->dropColumn('machine_id')->nullable();
        });
    }
}
