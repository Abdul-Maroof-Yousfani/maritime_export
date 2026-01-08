<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnQtyColumnInMaintenanceInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('maintenance_invoice_datas', function (Blueprint $table) {
            $table->decimal('return_qty')->nullable();
        });
        Schema::connection('mdf')->table('maintenance_invoice_datas', function (Blueprint $table) {
            $table->decimal('return_qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('maintenance_invoice_datas', function (Blueprint $table) {
            $table->dropColumn('return_qty');
        });
        Schema::connection('mdf')->table('maintenance_invoice_datas', function (Blueprint $table) {
            $table->dropColumn('return_qty');
        });
    }
}
