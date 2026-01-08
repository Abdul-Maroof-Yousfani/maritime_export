<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrcConciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('prc_conciliations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('conciliation_no')->nullable();
            $table->integer('prc_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->double('invoice_amount')->nullable();
            $table->double('booking_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('status')->default(0);
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
        Schema::connection('mysql2')->dropIfExists('prc_conciliations');
    }
}
