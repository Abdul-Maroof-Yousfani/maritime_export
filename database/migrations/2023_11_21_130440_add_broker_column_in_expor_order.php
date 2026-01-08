<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrokerColumnInExporOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->string('broker')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->string('broker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('broker');
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('broker');
        });
    }
}
