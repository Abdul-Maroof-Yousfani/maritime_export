<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConverstionMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('converstion_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sale_order_no')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('converstion_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sale_order_no')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('converstion_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sale_order_no')->nullable();
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
        Schema::dropIfExists('converstion_master');
    }
}
