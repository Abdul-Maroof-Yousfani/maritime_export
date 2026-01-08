<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubVarietyParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('sub_variety_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sub_variety_id'); 
            $table->string('moisture')->nullable();
            $table->string('damage')->nullable();
            $table->string('chalky')->nullable();
            $table->string('broken')->nullable();
            $table->string('o_v')->nullable();
            $table->string('chobba')->nullable();
            $table->string('look')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('sub_variety_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sub_variety_id'); 
            $table->string('moisture')->nullable();
            $table->string('damage')->nullable();
            $table->string('chalky')->nullable();
            $table->string('broken')->nullable();
            $table->string('o_v')->nullable();
            $table->string('chobba')->nullable();
            $table->string('look')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::connection('mysql_test')->create('sub_variety_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sub_variety_id'); 
            $table->string('moisture')->nullable();
            $table->string('damage')->nullable();
            $table->string('chalky')->nullable();
            $table->string('broken')->nullable();
            $table->string('o_v')->nullable();
            $table->string('chobba')->nullable();
            $table->string('look')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('sub_variety_parameters');
        Schema::connection('mdf')->dropIfExists('sub_variety_parameters');
        // Schema::connection('mysql_test')->dropIfExists('sub_variety_parameters');
    }
}

