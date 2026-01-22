<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('commercial_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_loading_id')->nullable();
            $table->integer('sale_order_export_id')->nullable();
            $table->string('invoice_no')->nullable(); // ST2526-040
            $table->date('invoice_date')->nullable();
            $table->string('gd_no')->nullable(); // KPEX-SB-86349-23-11-2025
            $table->string('container_no')->nullable(); // SEGU9709378
            $table->text('consignee_name')->nullable();
            $table->text('consignee_address')->nullable();
            $table->string('vessel_voyage')->nullable(); // CSPC LEO 004E
            $table->string('port_from')->nullable(); // KARACHI, PAKISTAN
            $table->string('port_to')->nullable(); // HO CHI MINH PORT, VIETNAM
            $table->string('payment_term')->nullable(); // BY TT
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('advance_amount', 15, 2)->default(0);
            $table->decimal('balance_amount', 15, 2)->default(0);
            $table->integer('currency_id')->nullable();
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->integer('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('commercial_invoices');
    }
}

