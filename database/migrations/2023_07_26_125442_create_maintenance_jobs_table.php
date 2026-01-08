<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('maintenance_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('maintenance_request_id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->decimal('labour_qty', 10, 2);
            $table->decimal('labour_amount', 10, 2);
            $table->date('completion_date');
            $table->string('instruct_by');
            $table->string('completed_by');
            $table->bigInteger('department_id');
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
        Schema::connection('mysql2')->dropIfExists('maintenance_jobs');
    }
}
