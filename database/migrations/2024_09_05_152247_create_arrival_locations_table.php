<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection('mysql2')->dropIfExists('arrival_locations');
        Schema::connection('mdf')->dropIfExists('arrival_locations');
        Schema::connection('mysql_test')->dropIfExists('arrival_locations');

        Schema::connection('mysql2')->create('arrival_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('arrival_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('arrival_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
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
        Schema::connection('mysql2')->dropIfExists('arrival_locations');
        Schema::connection('mdf')->dropIfExists('arrival_locations');
    }
}
