<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('prcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prc_no')->nullable();
            $table->integer('bank_id')->nullable();
            $table->date('date')->nullable();
            $table->double('amount')->nullable();
            $table->string('fwd_no')->nullable();
            $table->string('rate')->nullable();
            $table->date('start_date')->nullable();
            $table->date('maturity')->nullable();
            $table->double('balance')->nullable();
            $table->date('fixed_date')->nullable();
            $table->date('option_date')->nullable();
            $table->string('status')->nullable();
            $table->string('conciliation_status')->comment('Padding=0 , Partial = 1, Received =2')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('prcs');
    }
}
