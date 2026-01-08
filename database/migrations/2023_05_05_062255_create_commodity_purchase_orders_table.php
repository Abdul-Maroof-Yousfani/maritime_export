<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommodityPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('commodity_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('product_id');
            $table->bigInteger('crop_based_id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->bigInteger('location_id');
            $table->date('req_date')->nullable();
            $table->date('promise_date')->nullable();
            $table->bigInteger('party_id')->nullable();
            $table->date('order_rate')->nullable();
            $table->decimal('rate_per_kg')->nullable();
            $table->bigInteger('delivery_term')->nullable();
            $table->bigInteger('delivery_mode')->nullable();
            $table->bigInteger('comm_term')->nullable();
            $table->decimal('commision_per_bag')->nullable();
            $table->decimal('bardana_per_bag')->nullable();
            $table->decimal('freight_per_traller')->nullable();
            $table->decimal('qty_traller')->nullable();
            $table->decimal('qty_truck')->nullable();
            $table->decimal('qty_bag')->nullable();
            $table->decimal('qty_kg')->nullable();
            $table->decimal('qty_katta')->nullable();
            $table->decimal('po_amount')->nullable();
            $table->decimal('landed_rate_per_kg')->nullable();
            $table->boolean('status')->default(1);
            $table->string('username');
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
        Schema::dropIfExists('commodity_purchase_orders');
    }
}
