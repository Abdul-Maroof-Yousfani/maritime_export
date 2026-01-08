<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFumigationCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('fumigation_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ex_duities_id')->nullable();
            // Fumigation 
            $table->string('fumigation_text_area')->nullable();
            $table->string('chemical_treatment')->nullable();
            $table->string('chemical_concentration')->nullable();
            $table->string('name_address_expoter')->nullable();
            $table->string('name_address_consignee')->nullable();
            $table->string('mean_of_conveyance')->nullable();
            $table->string('distinguishing_marks')->nullable();
            $table->string('description_of_good')->nullable();
            $table->string('origin_certificate_shippers')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('fumigation_certificates');
    }
}
