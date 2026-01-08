<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoveColumnInProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('product');
        Schema::connection('mysql2')->create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('sku_code')->nullable();
            $table->boolean('batch_code')->nullable();
            $table->bigInteger('uom_id')->nullable();
            $table->bigInteger('table_type')->nullable();
            $table->bigInteger('type_id')->nullable();
            $table->bigInteger('packing_type')->nullable();
            $table->bigInteger('packing_size')->nullable();
            $table->bigInteger('min_stock')->nullable();
            $table->bigInteger('max_stock')->nullable();
            $table->boolean('status');
            $table->date('date');
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('product');
    }
}
