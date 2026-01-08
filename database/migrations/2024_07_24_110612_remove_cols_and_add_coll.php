<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColsAndAddColl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('material_request_datas', function (Blueprint $table) {
            $table->dropColumn('qty_approved');
            $table->renameColumn('qty_issued','stock_qty');
        });
        
        Schema::connection('mdf')->table('material_request_datas', function (Blueprint $table) {
            $table->dropColumn('qty_approved');
            $table->renameColumn('qty_issued','stock_qty');
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
