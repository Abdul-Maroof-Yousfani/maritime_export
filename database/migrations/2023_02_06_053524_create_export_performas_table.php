<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportPerformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('export_performas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_order_id');
            $table->string('eo_voucher_no');
            $table->string('correspondent_bank')->nuallable();
            $table->string('correspondent_account_usd')->nuallable();
            $table->string('correspondent_bank_swift')->nuallable();
            $table->string('details_of_payment')->nuallable();
            $table->string('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('export_performas');
    }
}
