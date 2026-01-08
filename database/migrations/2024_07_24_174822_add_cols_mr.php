<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsMr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->table('material_request_datas', function (Blueprint $table) {
            $table->bigInteger('warehouse_id');
        });
        Schema::connection('mysql2')->table('material_request_datas', function (Blueprint $table) {
            $table->bigInteger('warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mdf')->table('material_request_datas', function (Blueprint $table) {
            $table->dropColumn('warehouse_id');
        });
        Schema::connection('mysql2')->table('material_request_datas', function (Blueprint $table) {
            $table->dropColumn('warehouse_id');
        });
    }
}
