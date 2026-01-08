<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceInvoiceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('maintenance_invoice_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('maintenance_invoice_id');
            $table->bigInteger('item_id');
            $table->decimal('qty', 10,2);
            $table->decimal('rate', 10,2);
            $table->decimal('total', 10,2);
            $table->timestamps();
        });
        Schema::connection('mysql2')->table('maintenance_invoices', function(Blueprint $table){
            $table->decimal('labour_hour', 10,2)->default(0);
            $table->decimal('labour_wage', 10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('maintenance_invoice_datas');
        Schema::connection('mysql2')->table('maintenance_invoices', function(Blueprint $table){
            $table->dropColumn('labour_hour');
            $table->dropColumn('labour_wage');
        });
    }
}
