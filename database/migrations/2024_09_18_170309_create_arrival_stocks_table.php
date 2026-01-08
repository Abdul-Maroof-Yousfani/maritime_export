<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrivalStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no')->nullable();
            $table->string('ins_no')->nullable();
            $table->unsignedBigInteger('sub_variety_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('avg_qty')->nullable();
            $table->decimal('avg_rate')->nullable();
            $table->decimal('avg_amount')->nullable();
            $table->tinyInteger('type')->comment('1 = credit, 0 = debit');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('arrival_stocks', function (Blueprint $table) {
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
        Schema::connection('mysql2')->dropIfExists('arrival_stocks');
        Schema::connection('mdf')->dropIfExists('arrival_stocks');
    }
}
