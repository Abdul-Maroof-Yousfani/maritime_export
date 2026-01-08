<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualityDeclearCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('quality_declear_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ex_duities_id')->nullable();
              // quality Decleartion 
              $table->string('certificate_no')->nullable();
              $table->string('qulity_decleartion_shiper_name')->nullable();
              $table->string('bill_of_lading')->nullable();
              $table->string('qulity_decleartion_consignee')->nullable();
              $table->string('qulity_decleartion_shipper')->nullable();
              $table->string('qulity_decleartion_container_no')->nullable();
              $table->string('qulity_decleartion_number_of_bags')->nullable();
              $table->string('qulity_decleartion_net_weight')->nullable();
              $table->string('broken_grain')->nullable();
              $table->string('contaating_varieties')->nullable();
              $table->string('foreign_garin')->nullable();
              $table->string('foreign_matter')->nullable();
              $table->string('undermilled_red_striped')->nullable();
              $table->string('paddy_grain')->nullable();
              $table->string('damaged_discolour')->nullable();
              $table->string('chalky_kernal')->nullable();
              $table->string('moisture')->nullable();
              $table->string('averga_origin_length')->nullable();
              $table->string('whitness')->nullable();
              $table->string('crop')->nullable();
              $table->string('cadmimum')->nullable();
              $table->string('arsen')->nullable();
              $table->string('zinc')->nullable();
              $table->string('hg')->nullable();
  
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
        Schema::connection('mysql2')->dropIfExists('quality_declear_certificates');
    }
}
