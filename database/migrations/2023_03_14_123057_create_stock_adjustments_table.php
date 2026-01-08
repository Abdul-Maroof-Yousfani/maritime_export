<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('stock_adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('item_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('type');
            $table->decimal('qty', 10,2)->default(0);
            $table->decimal('rate', 10,2)->default(0);
            $table->longText('remarks')->nullable();
            $table->string('username')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('stock_adjustments');
    }
}
