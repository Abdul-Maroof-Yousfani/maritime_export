<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('maintenance_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->bigInteger('department_id');
            $table->bigInteger('machine_id');
            $table->bigInteger('line_id');
            $table->date('submit_date');
            $table->date('completion_date');
            $table->bigInteger('warehouse_id');
            $table->longText('description');
            $table->string('username');
            $table->integer('voucher_status')->default(1)->comment('1=>pending, 2=>approved');
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
        Schema::connection('mysql2')->dropIfExists('maintenance_requests');
    }
}
