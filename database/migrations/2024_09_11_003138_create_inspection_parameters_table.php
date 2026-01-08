<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('inspection_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parameter_id')->nullable(); // Parameter checker ID
            $table->string('ins_id')->nullable(); // Parameter checker ID
            $table->string('received_qty')->nullable(); // Received quantity
            $table->string('deduction')->nullable(); // Deduction value
            $table->string('total_deduction')->nullable(); // Total deduction based on calculation
            $table->timestamps();
        });
        Schema::connection('mdf')->create('inspection_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parameter_id')->nullable(); // Parameter checker ID
            $table->string('ins_id')->nullable(); // Parameter checker ID
            $table->string('received_qty')->nullable(); // Received quantity
            $table->string('deduction')->nullable(); // Deduction value
            $table->string('total_deduction')->nullable(); // Total deduction based on calculation
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('inspection_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parameter_id')->nullable(); // Parameter checker ID
            $table->string('ins_id')->nullable(); // Parameter checker ID
            $table->string('received_qty')->nullable(); // Received quantity
            $table->string('deduction')->nullable(); // Deduction value
            $table->string('total_deduction')->nullable(); // Total deduction based on calculation
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
        Schema::dropIfExists('inspection_parameters');
    }
}
