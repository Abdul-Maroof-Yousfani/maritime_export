<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyLocationColumnInGoodsReciptNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function (Blueprint $table) {
            $table->bigInteger('company_location_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function (Blueprint $table) {
            $table->dropColumn('company_location_id');
        });
    }
}
