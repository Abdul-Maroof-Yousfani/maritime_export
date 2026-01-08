<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('export_advance_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('advance_voucher_no');
            $table->integer('proforma_id');
            $table->integer('invoice_id')->default(0);
            $table->integer('invoice_data_id')->default(0);
            $table->integer('type')->comment('1= advance_received,2=setteled to invoice, 3=packing of Invoice');
            $table->integer('cr')->nullable();
            $table->integer('dr')->nullable();
            $table->double('advance_percent')->nullable();
            $table->double('advance_amount')->nullable();
            $table->double('received_amount')->nullable();
            $table->double('payment_status');
            $table->string('description')->nullable();
            $table->string('status');
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
        Schema::connection('mysql2')->dropIfExists('export_advance_payments');
    }
}
