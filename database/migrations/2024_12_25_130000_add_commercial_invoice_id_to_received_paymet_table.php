<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommercialInvoiceIdToReceivedPaymetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('received_paymet', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('received_paymet', 'commercial_invoice_id')) {
                $table->integer('commercial_invoice_id')->nullable()->after('sales_tax_invoice_id');
            }
            if (!Schema::connection('mysql2')->hasColumn('received_paymet', 'commercial_invoice_no')) {
                $table->string('commercial_invoice_no')->nullable()->after('commercial_invoice_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('received_paymet', function (Blueprint $table) {
            if (Schema::connection('mysql2')->hasColumn('received_paymet', 'commercial_invoice_no')) {
                $table->dropColumn('commercial_invoice_no');
            }
            if (Schema::connection('mysql2')->hasColumn('received_paymet', 'commercial_invoice_id')) {
                $table->dropColumn('commercial_invoice_id');
            }
        });
    }
}
