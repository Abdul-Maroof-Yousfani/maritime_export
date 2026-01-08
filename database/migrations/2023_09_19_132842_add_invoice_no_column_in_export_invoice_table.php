<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceNoColumnInExportInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_invoices', function ($table) {
            $table->string('commercial_invoice_no')->nullable();
        });
        Schema::connection('mdf')->table('export_invoices', function ($table) {
            $table->string('commercial_invoice_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_invoices', function ($table) {
            $table->dropColumn('commercial_invoice_no')->nullable();
        });
        Schema::connection('mdf')->table('export_invoices', function ($table) {
            $table->dropColumn('commercial_invoice_no')->nullable();
        });
    }
}
