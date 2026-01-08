<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('demand_quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('quotation_id');
            $table->bigInteger('quotation_data_id');
            $table->bigInteger('demand_id');
            $table->bigInteger('demand_data_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demand_quotations');
    }
}
