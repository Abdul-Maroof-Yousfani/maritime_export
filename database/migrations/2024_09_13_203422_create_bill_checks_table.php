<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('bill_checks');
        Schema::connection('mdf')->dropIfExists('bill_checks');
        Schema::connection('mysql_test')->dropIfExists('bill_checks');

        Schema::connection('mysql2')->create('bill_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no', 255)->nullable(); // Adds po_no column
            $table->string('bill_no', 255)->nullable(); // Adds bill_no column
            $table->timestamps();
        });

        Schema::connection('mdf')->create('bill_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no', 255)->nullable(); // Adds po_no column
            $table->string('bill_no', 255)->nullable(); // Adds bill_no column
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('bill_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no', 255)->nullable(); // Adds po_no column
            $table->string('bill_no', 255)->nullable(); // Adds bill_no column
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
        Schema::dropIfExists('bill_checks');
    }
}
