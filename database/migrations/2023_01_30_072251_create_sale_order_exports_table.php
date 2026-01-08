<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('sale_order_exports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucehr_no');
            $table->date('voucher_date');
            $table->string('voucher_type');
            $table->integer('buyer_id');
            $table->string('buyers_ntn');
            $table->string('model_terms_of_payment')->nullable();
            $table->date('due_date');
            $table->string('base_legnth')->nullable();
            $table->string('broken_grain')->nullable();
            $table->string('mosture_content')->nullable();
            $table->string('demand_yellow_grain')->nullable();
            $table->string('chalky_grain')->nullable();
            $table->string('foreign_grain')->nullable();
            $table->string('paddy_grain')->nullable();
            $table->string('under_milled')->nullable();
            $table->string('milled_double_polish')->nullable();
            $table->string('whiteness')->nullable();
            $table->integer('incoterm')->nullable();
            $table->integer('mode_transport')->nullable();
            $table->string('origin')->nullable();
            $table->string('port_of_discharge')->nullable();
            $table->string('port_loading')->nullable();
            $table->string('hs_code')->nullable();
            $table->string('partial_payment')->nullable();
            $table->integer('bank')->nullable();
            $table->date('delevery_date')->nullable();
            $table->integer('transhipment')->nullable();
            $table->integer('insurance_coverd')->nullable();
            $table->integer('advance_payment')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('sale_order_exports');
    }
}
