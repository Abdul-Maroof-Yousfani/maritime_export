<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AudtiorApprovalInDemand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('demand', function (Blueprint $table) {
            $table->integer('aud_approval_status')->nullable();
            $table->string('aud_approval_username')->nullable();
            $table->longText('aud_description')->nullable();
            $table->dateTime('aud_date_time')->nullable();
        });
        Schema::connection('mdf')->table('demand', function (Blueprint $table) {
            $table->integer('aud_approval_status')->nullable();
            $table->string('aud_approval_username')->nullable();
            $table->longText('aud_description')->nullable();
            $table->dateTime('aud_date_time')->nullable();
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
