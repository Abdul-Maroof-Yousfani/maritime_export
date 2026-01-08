<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInArrivalReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_report_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arrival_report_id')->nullable();
            $table->string('dc_no')->nullable();
            $table->string('igp_no')->nullable();
            $table->string('department_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('pr_po_no')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('qty_requested', 10, 2)->default(0);
            $table->decimal('qty_approved', 10, 2)->default(0);
            $table->decimal('accepted_qty', 10, 2)->default(0)->nullable();
            $table->decimal('rejected_qty', 10, 2)->default(0)->nullable();
            $table->longText('accept_reject_remarks')->nullable();
            $table->timestamps();
        });
        Schema::connection('mdf')->create('arrival_report_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arrival_report_id')->nullable();
            $table->string('dc_no')->nullable();
            $table->string('igp_no')->nullable();
            $table->string('department_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('pr_po_no')->nullable();
            $table->string('item_id')->nullable();
            $table->string('item')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('qty_requested', 10, 2)->default(0);
            $table->decimal('qty_approved', 10, 2)->default(0);
            $table->decimal('accepted_qty', 10, 2)->default(0)->nullable();
            $table->decimal('rejected_qty', 10, 2)->default(0)->nullable();
            $table->longText('accept_reject_remarks')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('arrival_report_datas');
        Schema::connection('mdf')->dropIfExists('arrival_report_datas');
    }
}
