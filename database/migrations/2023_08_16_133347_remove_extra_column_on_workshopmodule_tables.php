<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExtraColumnOnWorkshopmoduleTables extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function (Blueprint $table) {
            $table->dropColumn('labour_description');
            $table->dropColumn('labour_amount');
            $table->dropColumn('completion_date');
            $table->dropColumn('instruct_by');
            $table->dropColumn('completed_by');
            $table->dropColumn('department_id');
            $table->bigInteger('warehouse_id')->nullable();
        });
        Schema::connection('mysql2')->table('maintenance_job_datas', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('total');
        });
        Schema::connection('mysql2')->table('maintenance_invoices', function (Blueprint $table) {
            $table->date('completion_date');
            $table->string('instruct_by');
            $table->string('completed_by');
            $table->bigInteger('department_id');
        });

        // other Company
        Schema::connection('mdf')->table('maintenance_jobs', function (Blueprint $table) {
            $table->dropColumn('labour_description');
            $table->dropColumn('labour_amount');
            $table->dropColumn('completion_date');
            $table->dropColumn('instruct_by');
            $table->dropColumn('completed_by');
            $table->dropColumn('department_id');
            $table->bigInteger('warehouse_id')->nullable();
        });
        Schema::connection('mdf')->table('maintenance_job_datas', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('total');
        });
        Schema::connection('mdf')->table('maintenance_invoices', function (Blueprint $table) {
            $table->date('completion_date');
            $table->string('instruct_by');
            $table->string('completed_by');
            $table->bigInteger('department_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function (Blueprint $table) {
            $table->string('labour_description');
            $table->decimal('labour_amount', 10,2);
            $table->date('completion_date');
            $table->string('instruct_by');
            $table->string('completed_by');
            $table->bigInteger('department_id');
            $table->dropColumn('warehouse_id');
        });
        Schema::connection('mysql2')->table('maintenance_job_datas', function (Blueprint $table) {
            $table->decimal('rate', 10, 2);
            $table->decimal('total', 10, 2);
        });
        Schema::connection('mysql2')->table('maintenance_invoices', function (Blueprint $table) {
            $table->dropColumn('completion_date');
            $table->dropColumn('instruct_by');
            $table->dropColumn('completed_by');
            $table->dropColumn('department_id');
        });

        // other company

        Schema::connection('mdf')->table('maintenance_jobs', function (Blueprint $table) {
            $table->string('labour_description');
            $table->decimal('labour_amount', 10,2);
            $table->date('completion_date');
            $table->string('instruct_by');
            $table->string('completed_by');
            $table->bigInteger('department_id');
            $table->dropColumn('warehouse_id');
        });
        Schema::connection('mdf')->table('maintenance_job_datas', function (Blueprint $table) {
            $table->decimal('rate', 10, 2);
            $table->decimal('total', 10, 2);
        });
        Schema::connection('mdf')->table('maintenance_invoices', function (Blueprint $table) {
            $table->dropColumn('completion_date');
            $table->dropColumn('instruct_by');
            $table->dropColumn('completed_by');
            $table->dropColumn('department_id');
        });
    }
}
