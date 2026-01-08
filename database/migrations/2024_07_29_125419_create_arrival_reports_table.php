<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arrival_no')->nullable();
            $table->string('arrival_date')->nullable();
            $table->string('company_location_id')->nullable();
            $table->longText('arrival_remarks')->nullable();
            $table->boolean('arrival_approve')->default(0)->comment('0=>pending,1=>approves');
            $table->string('approve_name')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('requested_by')->nullable();
            $table->boolean('audit_approved')->default(0)->comment('0=>not recieved,1=>recieved');
            $table->string('audit_date')->nullable();
            $table->string('audit_name')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('arrival_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('arrival_no')->nullable();
            $table->string('arrival_date')->nullable();
            $table->string('company_location_id')->nullable();
            $table->longText('arrival_remarks')->nullable();
            $table->boolean('arrival_approve')->default(0)->comment('0=>pending,1=>approves');
            $table->string('approve_name')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('requested_by')->nullable();
            $table->boolean('audit_approved')->default(0)->comment('0=>not recieved,1=>recieved');
            $table->string('audit_date')->nullable();
            $table->string('audit_name')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('arrival_reports');
        Schema::connection('mdf')->dropIfExists('arrival_reports');
    }
}
