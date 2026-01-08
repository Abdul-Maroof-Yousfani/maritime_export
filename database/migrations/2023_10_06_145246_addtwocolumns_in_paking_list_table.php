<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddtwocolumnsInPakingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_paking_lists', function (Blueprint $table) {
            $table->longText('consignee')->nullable();
            $table->longText('notify')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_paking_lists', function (Blueprint $table) {
            $table->dropColumn('consignee');
            $table->dropColumn('notify');
        });
    }
}
