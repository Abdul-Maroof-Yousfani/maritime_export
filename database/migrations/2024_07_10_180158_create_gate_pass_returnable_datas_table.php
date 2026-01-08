<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePassReturnableDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gate_pass_returnables_id');
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->string('qty')->nullable();
            $table->string('line_no')->nullable();
            $table->longText('line_description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gate_pass_returnables_id');
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->string('qty')->nullable();
            $table->string('line_no')->nullable();
            $table->longText('line_description')->nullable();
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
        Schema::connection('mdf')->dropIfExists('gate_pass_returnable_datas');
        Schema::connection('mysql2')->dropIfExists('gate_pass_returnable_datas');
    }
}
