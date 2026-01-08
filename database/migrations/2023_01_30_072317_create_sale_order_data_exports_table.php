<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderDataExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('sale_order_data_exports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_order_export_id');
            $table->integer('item_id');
            $table->string('uom_id');
            $table->string('pack_size_pack_type');
            $table->string('pack_qty');
            $table->string('pack_size');
            $table->string('flc_size');
            $table->string('flc_qty');
            $table->string('actual_qty');
            $table->string('rate');
            $table->double('amount');
            $table->string('tax')->nullable();
            $table->double('tax_amount')->nullable();
            $table->string('after_dis_amount')->nullable();
            $table->string('sales_total')->nullable();
            $table->string('rupeess')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('sale_order_data_exports');
    }
}
