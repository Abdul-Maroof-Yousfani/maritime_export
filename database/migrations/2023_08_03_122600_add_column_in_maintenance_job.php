<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInMaintenanceJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('maintenance_jobs', function (Blueprint $table) {
            $table->integer('job_type')->comment('1->inhouse, 2->outsource')->before('created_at');
            $table->bigInteger('supplier_id')->nullable()->before('created_at');
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
            $table->dropColumn('job_type');
            $table->dropColumn('supplier_id');
        });
    }
}
