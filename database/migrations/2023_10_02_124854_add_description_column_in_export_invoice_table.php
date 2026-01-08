<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionColumnInExportInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_invoices', function ($table) {
            $table->longText('description')->nullable();
        });
        Schema::connection('mdf')->table('export_invoices', function ($table) {
            $table->longText('description')->nullable();
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
            $table->dropcolumn('description');
        });
        Schema::connection('mdf')->table('export_invoices', function ($table) {
            $table->dropcolumn('description');
        });
    }
}
