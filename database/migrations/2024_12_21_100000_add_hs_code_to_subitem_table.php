<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHsCodeToSubitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('subitem', function (Blueprint $table) {
            $table->string('hs_code')->nullable()->after('pack_type');
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
            $table->dropColumn('hs_code');
        });
    }
}

