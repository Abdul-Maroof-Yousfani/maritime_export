<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNewProductionPrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::connection('mysql2')->dropIfExists('production_purchase_orders');
        Schema::connection('mdf')->dropIfExists('production_purchase_orders');
        Schema::connection('mysql_test')->dropIfExists('production_purchase_orders');

        Schema::connection('mysql2')->create('production_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->bigInteger('product_id');
            $table->bigInteger('subitem_id');
            $table->integer('location_id')->nullable();
            $table->integer('crop_based_id')->nullable();
            $table->bigInteger('agent_id')->nullable();
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->date('req_date')->nullable();
            $table->date('promise_date')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->decimal('order_rate', 15, 2)->nullable();
            $table->string('delivery_term')->nullable();
            $table->string('is_replaceable')->nullable();
            $table->string('brokery_term')->nullable();
            $table->string('payment_term')->nullable();
            $table->decimal('po_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('voucher_status')->default(1)->comment('1 => pending, 2 => partial, 3 => complete');
            $table->decimal('rate_per_kg', 15, 2)->nullable();
            $table->string('max_delivery_mode')->nullable();
            $table->decimal('max_qty_traller', 15, 2)->nullable();
            $table->decimal('max_qty_truck', 15, 2)->nullable();
            $table->decimal('max_qty_bag', 15, 2)->nullable();
            $table->decimal('max_qty_katta', 15, 2)->nullable();
            $table->decimal('max_qty_kg', 15, 2)->nullable();
            $table->string('min_delivery_mode')->nullable();
            $table->decimal('min_qty_traller', 15, 2)->nullable();
            $table->decimal('min_qty_truck', 15, 2)->nullable();
            $table->decimal('min_qty_bag', 15, 2)->nullable();
            $table->decimal('min_qty_katta', 15, 2)->nullable();
            $table->decimal('min_qty_kg', 15, 2)->nullable();
            $table->decimal('commission_per_bag', 15, 2)->nullable();
            $table->decimal('bardana_per_bag', 15, 2)->nullable();
            $table->decimal('misc_exp_per_bag', 15, 2)->nullable();
            $table->decimal('freight_per_traller', 15, 2)->nullable();
            $table->decimal('moisture', 5, 2)->nullable();
            $table->decimal('damage', 5, 2)->nullable();
            $table->decimal('chalky', 5, 2)->nullable();
            $table->decimal('broken', 5, 2)->nullable();
            $table->decimal('o_v', 5, 2)->nullable();
            $table->decimal('look', 5, 2)->nullable();
            $table->decimal('landed_rate_per_kg', 15, 2)->nullable();
            $table->string('username');
            $table->string('balance_qty');
            $table->timestamps();
        });

        Schema::connection('mdf')->create('production_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->bigInteger('product_id');
            $table->bigInteger('subitem_id');
            $table->integer('location_id')->nullable();
            $table->integer('crop_based_id')->nullable();
            $table->bigInteger('agent_id')->nullable();
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->date('req_date')->nullable();
            $table->date('promise_date')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->decimal('order_rate', 15, 2)->nullable();
            $table->string('delivery_term')->nullable();
            $table->string('is_replaceable')->nullable();
            $table->string('brokery_term')->nullable();
            $table->string('payment_term')->nullable();
            $table->decimal('po_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('voucher_status')->default(1)->comment('1 => pending, 2 => partial, 3 => complete');
            $table->decimal('rate_per_kg', 15, 2)->nullable();
            $table->string('max_delivery_mode')->nullable();
            $table->decimal('max_qty_traller', 15, 2)->nullable();
            $table->decimal('max_qty_truck', 15, 2)->nullable();
            $table->decimal('max_qty_bag', 15, 2)->nullable();
            $table->decimal('max_qty_katta', 15, 2)->nullable();
            $table->decimal('max_qty_kg', 15, 2)->nullable();
            $table->string('min_delivery_mode')->nullable();
            $table->decimal('min_qty_traller', 15, 2)->nullable();
            $table->decimal('min_qty_truck', 15, 2)->nullable();
            $table->decimal('min_qty_bag', 15, 2)->nullable();
            $table->decimal('min_qty_katta', 15, 2)->nullable();
            $table->decimal('min_qty_kg', 15, 2)->nullable();
            $table->decimal('commission_per_bag', 15, 2)->nullable();
            $table->decimal('bardana_per_bag', 15, 2)->nullable();
            $table->decimal('misc_exp_per_bag', 15, 2)->nullable();
            $table->decimal('freight_per_traller', 15, 2)->nullable();
            $table->decimal('moisture', 5, 2)->nullable();
            $table->decimal('damage', 5, 2)->nullable();
            $table->decimal('chalky', 5, 2)->nullable();
            $table->decimal('broken', 5, 2)->nullable();
            $table->decimal('o_v', 5, 2)->nullable();
            $table->decimal('look', 5, 2)->nullable();
            $table->decimal('landed_rate_per_kg', 15, 2)->nullable();
            $table->string('username');
            $table->string('balance_qty');
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('production_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->bigInteger('product_id');
            $table->bigInteger('subitem_id');
            $table->integer('location_id')->nullable();
            $table->integer('crop_based_id')->nullable();
            $table->bigInteger('agent_id')->nullable();
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->date('req_date')->nullable();
            $table->date('promise_date')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->decimal('order_rate', 15, 2)->nullable();
            $table->string('delivery_term')->nullable();
            $table->string('is_replaceable')->nullable();
            $table->string('brokery_term')->nullable();
            $table->string('payment_term')->nullable();
            $table->decimal('po_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('voucher_status')->default(1)->comment('1 => pending, 2 => partial, 3 => complete');
            $table->decimal('rate_per_kg', 15, 2)->nullable();
            $table->string('max_delivery_mode')->nullable();
            $table->decimal('max_qty_traller', 15, 2)->nullable();
            $table->decimal('max_qty_truck', 15, 2)->nullable();
            $table->decimal('max_qty_bag', 15, 2)->nullable();
            $table->decimal('max_qty_katta', 15, 2)->nullable();
            $table->decimal('max_qty_kg', 15, 2)->nullable();
            $table->string('min_delivery_mode')->nullable();
            $table->decimal('min_qty_traller', 15, 2)->nullable();
            $table->decimal('min_qty_truck', 15, 2)->nullable();
            $table->decimal('min_qty_bag', 15, 2)->nullable();
            $table->decimal('min_qty_katta', 15, 2)->nullable();
            $table->decimal('min_qty_kg', 15, 2)->nullable();
            $table->decimal('commission_per_bag', 15, 2)->nullable();
            $table->decimal('bardana_per_bag', 15, 2)->nullable();
            $table->decimal('misc_exp_per_bag', 15, 2)->nullable();
            $table->decimal('freight_per_traller', 15, 2)->nullable();
            $table->decimal('moisture', 5, 2)->nullable();
            $table->decimal('damage', 5, 2)->nullable();
            $table->decimal('chalky', 5, 2)->nullable();
            $table->decimal('broken', 5, 2)->nullable();
            $table->decimal('o_v', 5, 2)->nullable();
            $table->decimal('look', 5, 2)->nullable();
            $table->decimal('landed_rate_per_kg', 15, 2)->nullable();
            $table->string('username');
            $table->string('balance_qty');
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
        Schema::connection('mysql2')->dropIfExists('production_purchase_orders');
        Schema::connection('mdf')->dropIfExists('production_purchase_orders');
    }
}
