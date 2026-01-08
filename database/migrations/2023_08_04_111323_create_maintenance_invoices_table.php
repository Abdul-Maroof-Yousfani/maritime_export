<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('maintenance_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->bigInteger('maintenance_job_id');
            $table->integer('voucher_status')->default(1);
            $table->string('username');
            $table->boolean('status')->default(true);
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
        Schema::connection('mysql2')->dropIfExists('maintenance_invoices');
    }
}
