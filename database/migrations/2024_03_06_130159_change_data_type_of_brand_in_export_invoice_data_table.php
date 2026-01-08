<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDataTypeOfBrandInExportInvoiceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function(Blueprint $table){
            $table->text('brand')->change();
        });
        Schema::connection('mdf')->table('export_invoice_datas', function(Blueprint $table){
            $table->text('brand')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_invoice_datas', function(Blueprint $table){
            $table->string('brand')->change();
        });
        Schema::connection('mdf')->table('export_invoice_datas', function(Blueprint $table){
            $table->string('brand')->change();
        });
    }
}
