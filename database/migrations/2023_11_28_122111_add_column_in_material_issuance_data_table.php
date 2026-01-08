<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInMaterialIssuanceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->integer('status')->default(1);
        });
        Schema::connection('mdf')->table('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::connection('mdf')->table('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
