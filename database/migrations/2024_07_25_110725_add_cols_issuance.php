<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsIssuance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->table('issuance', function (Blueprint $table) {
            $table->bigInteger('material_id')->after('supplier_id');
            $table->string('material_no')->after('material_id');
        });
        Schema::connection('mysql2')->table('issuance', function (Blueprint $table) {
            $table->bigInteger('material_id')->after('supplier_id');
            $table->string('material_no')->after('material_id');
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
