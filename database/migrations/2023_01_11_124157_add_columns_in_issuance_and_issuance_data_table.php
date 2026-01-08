<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInIssuanceAndIssuanceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('issuance', function ($table) {
            $table->integer('department_id');
            $table->integer('receipt_serial_no');
            $table->integer('machine_id');
            $table->integer('line_id');
        });
        Schema::connection('mysql2')->table('issuance_data', function ($table) {
            $table->integer('warehouse_id');
            $table->integer('batch_code');
            $table->decimal('qty');
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
