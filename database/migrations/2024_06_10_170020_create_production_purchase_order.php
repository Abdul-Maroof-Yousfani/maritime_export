<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('production_purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->bigInteger('product_id');
            $table->bigInteger('crop_based_id');
            $table->bigInteger('agent_id')->nullable();
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->date('req_date')->nullable();
            $table->date('promise_date')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->decimal('order_rate')->nullable();
            $table->string('delivery_term')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->decimal('freight')->nullable();
            $table->decimal('po_amount')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->decimal('qty')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('voucher_status')->default(1)->comment(
                '1 => pending,
                2 => partial,
                3 => complete',
            );
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
        Schema::connection('mysql2')->dropIfExists('production_purchase_orders');
    }
}
