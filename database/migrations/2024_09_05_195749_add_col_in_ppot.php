<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInPpot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
            $table->decimal('chobba', 5, 2)->nullable();
        });
        Schema::connection('mdf')->table('production_purchase_orders', function (Blueprint $table) {
            $table->decimal('chobba', 5, 2)->nullable();
        });
        Schema::connection('mysql_test')->table('production_purchase_orders', function (Blueprint $table) {
            $table->decimal('chobba', 5, 2)->nullable();
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
