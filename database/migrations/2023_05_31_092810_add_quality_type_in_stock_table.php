<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQualityTypeInStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('issuance_return_datas', function (Blueprint $table) {
            $table->bigInteger('quality_type')->nullable()->default(1);
        });
        Schema::connection('mysql2')->table('stock', function (Blueprint $table) {
            $table->bigInteger('quality_type')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('issuance_return_datas', function (Blueprint $table) {
            $table->dropColumn('quality_type');
        });
        Schema::connection('mysql2')->table('stock', function (Blueprint $table) {
            $table->dropColumn('quality_type');
        });
    }
}
