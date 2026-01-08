<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInPo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
             $table->string('company_location_id')->nullable();
             $table->longText('remarks')->nullable();
        });
        Schema::connection('mdf')->table('production_purchase_orders', function (Blueprint $table) {
             $table->string('company_location_id')->nullable();
             $table->longText('remarks')->nullable();
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
