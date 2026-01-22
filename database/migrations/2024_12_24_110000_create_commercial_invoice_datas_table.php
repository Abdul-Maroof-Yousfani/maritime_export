<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialInvoiceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('commercial_invoice_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commercial_invoice_id')->nullable();
            $table->integer('sale_order_data_export_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->text('description')->nullable(); // FROZEN SQUID WHOLE PACKING: 20 KG/CTN (LOLIGO EDULIS)
            $table->string('grade_size')->nullable(); // 20/40-A+
            $table->integer('total_cartons')->default(0); // 1250
            $table->decimal('total_net_kgs', 15, 2)->default(0); // 25000
            $table->decimal('rate_cfr_per_kg', 15, 4)->default(0); // 3.11
            $table->decimal('amount_usd', 15, 2)->default(0); // 77,750.00
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
        Schema::connection('mysql2')->dropIfExists('commercial_invoice_datas');
    }
}

