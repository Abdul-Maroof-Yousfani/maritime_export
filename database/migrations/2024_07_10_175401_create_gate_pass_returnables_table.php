<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePassReturnablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('gate_pass_returnables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gatepass_type');
            $table->string('gatepass_no');
            $table->string('vendor_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('builty_no')->nullable();
            $table->date('date')->nullable();
            $table->string('ref_no')->nullable();
            $table->date('ref_date')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('type')->nullable();
            $table->string('requested_by')->nullable();
            $table->longText('remarks')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('gate_pass_returnables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gatepass_type');
            $table->string('gatepass_no');
            $table->string('vendor_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('builty_no')->nullable();
            $table->date('date')->nullable();
            $table->string('ref_no')->nullable();
            $table->date('ref_date')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('type')->nullable();
            $table->string('requested_by')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('gate_pass_returnables');
        Schema::connection('mdf')->dropIfExists('gate_pass_returnables');
    }
}
