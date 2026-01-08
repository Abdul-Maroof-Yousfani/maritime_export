<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapDeclrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('scrap_declrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sd_no')->nullable();
            $table->string('sd_date')->nullable();
            $table->string('company_location_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('line_no')->nullable();
            $table->longText('sd_remarks')->nullable();
            $table->boolean('scrap_approve')->default(0)->comment('0=>pending,1=>approves');
            $table->string('approve_name')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('requested_by')->nullable();
            $table->boolean('aud_approval_status')->default(0)->comment('0=>pending,1=>approves');
            $table->string('aud_description')->nullable();
            $table->string('aud_date_time')->nullable();
            $table->string('aud_approval_username')->nullable();
            $table->boolean('gm_approval_status')->default(0)->comment('0=>pending,1=>approves');
            $table->string('gm_description')->nullable();
            $table->string('gm_approval_username')->nullable();
            $table->string('gm_date_time')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::connection('mdf')->create('scrap_declrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sd_no')->nullable();
            $table->string('sd_date')->nullable();
            $table->string('company_location_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('line_no')->nullable();
            $table->longText('sd_remarks')->nullable();
            $table->boolean('scrap_approve')->default(0)->comment('0=>pending,1=>approves');
            $table->string('approve_name')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('requested_by')->nullable();
            $table->boolean('aud_approval_status')->default(0)->comment('0=>pending,1=>approves');
            $table->string('aud_description')->nullable();
            $table->string('aud_date_time')->nullable();
            $table->string('aud_approval_username')->nullable();
            $table->boolean('gm_approval_status')->default(0)->comment('0=>pending,1=>approves');
            $table->string('gm_description')->nullable();
            $table->string('gm_approval_username')->nullable();
            $table->string('gm_date_time')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('scrap_declrations');
        Schema::connection('mdf')->dropIfExists('scrap_declrations');
    }
}
