<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionPurhaseOrderDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('inspection_purhase_order_datas', function (Blueprint $table) {
//            $table->increments('id');
//            $table->timestamps();
//        });

        Schema::connection('mysql2')->dropIfExists('inspection_purhase_order_datas');
        Schema::connection('mdf')->dropIfExists('inspection_purhase_order_datas');
        Schema::connection('mysql_test')->dropIfExists('inspection_purhase_order_datas');

        Schema::connection('mysql2')->create('inspection_purhase_order_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no')->nullable();
            $table->string('received_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
            $table->timestamps();
        });

        Schema::connection('mdf')->create('inspection_purhase_order_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no')->nullable();
            $table->string('received_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
        });

        Schema::connection('mysql_test')->create('inspection_purhase_order_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no')->nullable();
            $table->string('received_qty')->nullable();
            $table->string('reject_qty')->nullable();
            $table->string('total_qty')->nullable();
            $table->string('balance_qty')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_purhase_order_datas');
    }
}
