<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportInvoiceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('export_invoice_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('export_invoice_id')->nullable();
            $table->integer('sale_order_export_data_id')->nullable();
            $table->integer('issue_qty')->nullable();
            $table->integer('remaing_qty')->nullable();
            $table->string('brand')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('export_invoice_datas');
    }
}
