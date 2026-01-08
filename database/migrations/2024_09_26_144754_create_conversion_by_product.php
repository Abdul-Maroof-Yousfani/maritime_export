<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversionByProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('converstion_by_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_detail_id');
            $table->string('by_product_head')->nullable(); // By Product Head
            $table->string('breakup')->nullable(); // Breakup
            $table->integer('qty')->nullable(); // Qty
            $table->string('uom_kg')->nullable(); // UOM in Kgs
            $table->string('uom_ton')->nullable(); // UOM in Ton
            $table->timestamps();
        });

        Schema::connection('mdf')->create('converstion_by_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_detail_id');
            $table->string('by_product_head')->nullable(); // By Product Head
            $table->string('breakup')->nullable(); // Breakup
            $table->integer('qty')->nullable(); // Qty
            $table->string('uom_kg')->nullable(); // UOM in Kgs
            $table->string('uom_ton')->nullable(); // UOM in Ton
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('converstion_by_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_detail_id');
            $table->string('by_product_head')->nullable(); // By Product Head
            $table->string('breakup')->nullable(); // Breakup
            $table->integer('qty')->nullable(); // Qty
            $table->string('uom_kg')->nullable(); // UOM in Kgs
            $table->string('uom_ton')->nullable(); // UOM in Ton
            $table->timestamps();
        });


        Schema::connection('mysql_test')->dropIfExists('arrival_stocks');
        Schema::connection('mysql_test')->create('arrival_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no')->nullable();
            $table->unsignedBigInteger('sub_variety_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('location_id');
            $table->decimal('qty')->nullable();
            $table->tinyInteger('type')->comment('1 = credit, 0 = debit');
            $table->tinyInteger('status')->default(1);
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
        //
    }
}
