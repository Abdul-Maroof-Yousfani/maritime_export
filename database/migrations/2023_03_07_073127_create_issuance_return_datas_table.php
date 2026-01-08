<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuanceReturnDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql2")->create('issuance_return_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('issuance_data_id');
            $table->bigInteger('sub_item_id');
            $table->bigInteger('sub_item_remark');
            $table->bigInteger('warehouse_id');
            $table->string('batch_code')->default("0");
            $table->decimal('issuace_qty', 10,2);
            $table->decimal('return_qty', 10,2);
            $table->integer('voucher_status')->nullable()->default(1)->comment("1=>PENDING, 2=>Approve");
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
        Schema::dropIfExists('issuance_return_datas');
    }
}
