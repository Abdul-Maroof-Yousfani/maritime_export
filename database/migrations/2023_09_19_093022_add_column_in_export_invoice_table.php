<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInExportInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function ($table) {
            $table->decimal('gross_weight', 10, 2)->nullable();
        });
        Schema::connection('mdf')->table('export_invoice_datas', function ($table) {
            $table->decimal('gross_weight', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function ($table) {
            $table->dropColumn('gross_weight')->nullable();
        });
        Schema::connection('mdf')->table('export_invoice_datas', function ($table) {
            $table->dropColumn('gross_weight')->nullable();
        });
    }
}
