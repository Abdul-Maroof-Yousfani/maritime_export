<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_slips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no');
            $table->string('arrival_slip_no');
            $table->unsignedBigInteger('department_id');
            $table->date('arrival_date');
            $table->date('bill_date');
            $table->string('sp_inv_no');
            $table->string('document_mode');
            $table->tinyInteger('recived_type')->default(0)->comment('1 Complete Recived, 2 Partial Recived');
            $table->decimal('qty')->nullable();
            $table->decimal('received_qty')->nullable();
            $table->decimal('rejected_qty')->nullable();
            $table->decimal('bal_qty')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('arrival_slips');
    }
}
