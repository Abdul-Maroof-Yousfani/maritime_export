<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyzingMrDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->create('analyzing_mr_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('analyzing_mr_id')->nullable();
            $table->string('equipment_reference')->nullable();
            $table->string('section')->nullable();
            $table->string('category')->nullable();
            $table->string('common_issue')->nullable();
            $table->string('staff_intelegence')->nullable();
            $table->text('detail')->nullable();
            $table->integer('status')->nullable();
            $table->string('username')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
         });
         Schema::connection('mysql2')->create('analyzing_mr_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('analyzing_mr_id')->nullable();
            $table->string('equipment_reference')->nullable();
            $table->string('section')->nullable();
            $table->string('category')->nullable();
            $table->string('common_issue')->nullable();
            $table->string('staff_intelegence')->nullable();
            $table->text('detail')->nullable();
            $table->integer('status')->nullable();
            $table->string('username')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('analyzing_mr_data');
        Schema::connection('mdf')->dropIfExists('analyzing_mr_data');
    }
}
