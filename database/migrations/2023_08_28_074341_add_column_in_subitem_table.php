<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInSubitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('subitem', function (Blueprint $table) {
            $table->bigInteger('pack_uom')->nullable();
        });
        Schema::connection('mdf')->table('subitem', function (Blueprint $table) {
            $table->bigInteger('pack_uom')->nullable();
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
            $table->dropColumn('pack_uom');
        });
        Schema::connection('mdf')->table('subitem', function (Blueprint $table) {
            $table->dropColumn('pack_uom');
        });
    }
}
