<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapDeclrationDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('scrap_declration_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scrap_declration_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_desc')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('qty', 10, 2)->default(0);
            $table->longText('reason_for_scrapping')->nullable();
            $table->timestamps();
        });

        Schema::connection('mdf')->create('scrap_declration_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scrap_declration_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_desc')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('qty', 10, 2)->default(0);
            $table->longText('reason_for_scrapping')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('scrap_declration_datas');
        Schema::connection('mdf')->dropIfExists('scrap_declration_datas');
    }
}
