<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsInQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('quotation', function (Blueprint $table) {
            $table->string('prepare_date')->nullable();
            $table->string('checked_date')->nullable();
            $table->string('audited_date')->nullable();
            $table->string('approved_date')->nullable();
        });
        Schema::connection('mdf')->table('quotation', function (Blueprint $table) {
            $table->string('prepare_date')->nullable();
            $table->string('checked_date')->nullable();
            $table->string('audited_date')->nullable();
            $table->string('approved_date')->nullable();
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
