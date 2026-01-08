<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInGoodReciptNoteDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function ($table) {
            $table->boolean('force_complete')->default(0);
        });
        Schema::connection('mysql2')->table('grn_data', function ($table) {
            $table->boolean('force_complete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('goods_receipt_note', function ($table) {
            $table->dropColumn('force_complete');
        });
        Schema::connection('mysql2')->table('grn_data', function ($table) {
            $table->dropColumn('force_complete');
        });
    }
}
