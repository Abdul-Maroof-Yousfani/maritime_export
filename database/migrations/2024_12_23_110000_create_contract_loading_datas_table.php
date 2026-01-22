<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractLoadingDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('contract_loading_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_loading_id');
            $table->integer('sale_order_data_export_id');
            $table->integer('item_id');
            $table->string('layer')->nullable();
            $table->decimal('qty', 15, 2)->default(0);
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
        Schema::connection('mysql2')->dropIfExists('contract_loading_datas');
    }
}

