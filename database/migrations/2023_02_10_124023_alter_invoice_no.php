<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvoiceNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::connection('mysql2')->table('export_invoices', function($table) {
            $table->string('ship_name')->after('form_no')->nullable();
            $table->string('bill_of_loading')->after('ship_name')->nullable();
            $table->string('consigned_deatils')->after('bill_of_loading')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
