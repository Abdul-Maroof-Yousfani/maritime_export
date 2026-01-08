<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialRequestDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('material_request_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('material_request_id');
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->string('material_code')->nullable();
            $table->decimal('qty_requested', 10, 2)->default(0,00);
            $table->decimal('qty_approved', 10, 2)->default(0,00);
            $table->decimal('qty_issued', 10, 2)->default(0,00);
            $table->longText('material_description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('material_request_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('material_request_id');
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->string('material_code')->nullable();
            $table->decimal('qty_requested', 10, 2)->default(0,00);
            $table->decimal('qty_approved', 10, 2)->default(0,00);
            $table->decimal('qty_issued', 10, 2)->default(0,00);
            $table->longText('material_description')->nullable();
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
       Schema::connection('mysql2')->dropIfExists('material_request_datas');
       Schema::connection('mdf')->dropIfExists('material_request_datas');
    }
}
