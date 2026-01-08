<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInExportOrderAndCommercialInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->string('voucher_heading')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->string('voucher_heading')->nullable();
        });
        Schema::connection('mysql2')->table('export_invoices', function (Blueprint $table) {
            $table->string('master_bl')->nullable();
        });
        Schema::connection('mdf')->table('export_invoices', function (Blueprint $table) {
            $table->string('master_bl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('voucher_heading');
        });
        Schema::connection('mdf')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn('voucher_heading');
        });
        Schema::connection('mysql2')->table('export_invoices', function (Blueprint $table) {
            $table->dropColumn('master_bl');
        });
        Schema::connection('mdf')->table('export_invoices', function (Blueprint $table) {
            $table->dropColumn('master_bl');
        });
    }
}
