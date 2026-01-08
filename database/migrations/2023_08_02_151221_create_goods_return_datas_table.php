<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReturnDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('goods_return_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('goods_return_id');
            $table->bigInteger('item_id');
            $table->bigInteger('quality_type');
            $table->decimal('qty', 10 ,2);
            $table->decimal('rate', 10, 2);
            $table->decimal('total', 10, 2);
            $table->longText('item_remark')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::connection('mysql2')->dropIfExists('goods_return_datas');
    }
}
