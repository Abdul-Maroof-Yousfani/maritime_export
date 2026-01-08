<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInCropBasedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('crop_baseds', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id'); 
        });
        Schema::connection('mdf')->table('crop_baseds', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id'); 
        });

        Schema::connection('mysql_test')->table('crop_baseds', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
