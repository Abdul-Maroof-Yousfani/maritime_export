<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScientificNameToSubitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('subitem', function (Blueprint $table) {
            $table->string('scientific_name')->nullable()->after('sub_ic');
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
            $table->dropColumn('scientific_name');
        });
    }
}

