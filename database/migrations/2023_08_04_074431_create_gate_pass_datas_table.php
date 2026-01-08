<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePassDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('gate_pass_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gate_pass_id');
            $table->bigInteger('item_id');
            $table->decimal('qty')->default(0);
            $table->decimal('qty_received')->default(0);
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
        Schema::connection('mysql2')->dropIfExists('gate_pass_datas');
    }
}
