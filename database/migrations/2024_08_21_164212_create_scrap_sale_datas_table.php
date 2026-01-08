<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapSaleDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('scrap_sale_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scrap_sale_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('item')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_desc')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('rate', 10,2);
            $table->decimal('total', 10,2);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('scrap_sale_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scrap_sale_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('item')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_desc')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('qty', 10, 2)->default(0);
            $table->decimal('rate', 10,2);
            $table->decimal('total', 10,2);
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
        Schema::connection('mysql2')->dropIfExists('scrap_sale_datas');
        Schema::connection('mdf')->dropIfExists('scrap_sale_datas');
    }
}
