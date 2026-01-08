<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsinProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('product', function (Blueprint $table) {
            $table->string('variety_type')->nullable(); 
        });
        Schema::connection('mdf')->table('product', function (Blueprint $table) {
            $table->string('variety_type')->nullable(); 
        });

        Schema::connection('mysql_test')->table('product', function (Blueprint $table) {
            $table->string('variety_type')->nullable(); 
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
