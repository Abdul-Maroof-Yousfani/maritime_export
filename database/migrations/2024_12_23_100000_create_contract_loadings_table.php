<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractLoadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('contract_loadings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_order_export_id');
            $table->string('contract_no');
            $table->date('loading_date');
            $table->string('vehicle_no')->nullable();
            $table->string('name')->nullable();
            $table->string('container_no')->nullable();
            $table->string('seal_no')->nullable();
            $table->integer('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('contract_loadings');
    }
}

