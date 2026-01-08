<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualityPackingCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('quality_packing_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ex_duities_id')->nullable();
            // Quality packing
             $table->string('quality_packing_shipper')->nullable();
             $table->string('quality_packing_consignee')->nullable();
             $table->string('quality_packing_description_of_good')->nullable();
             $table->string('quality_packing_packing')->nullable();
             $table->string('quality_packing_origin')->nullable();
             $table->string('quality_packing_declared_quality')->nullable();
             $table->string('quality_packing_vessel')->nullable();
             $table->string('quality_packing_port_of_loading')->nullable();
             $table->string('quality_packing_of_discharge')->nullable();
             $table->string('quality_packing_Bl_no')->nullable();
             $table->string('quality_packing_container_no')->nullable();
             $table->string('quality_packing_lot_no')->nullable();
             $table->string('quality_packing_weight')->nullable();
             $table->string('quality_packing_date_of_production')->nullable();
             $table->string('quality_packing_quality')->nullable();
             $table->string('quality_packing_broken')->nullable();
             $table->string('quality_packing_damaged_discolor_karnel')->nullable();
             $table->string('quality_packing_chalky_karnel')->nullable();
             $table->string('quality_packing_contrasting_varities')->nullable();
             $table->string('quality_packing_foreign_grain')->nullable();
             $table->string('quality_packing_paddy_grain')->nullable();
             $table->string('quality_packing_undermilled_and_red')->nullable();
             $table->string('quality_packing_moisture')->nullable();
             $table->string('quality_packing_average_grain_lenght')->nullable();
             $table->string('quality_packing_whiteness')->nullable();
             $table->string('quality_packing_crop')->nullable();
             $table->string('quality_packing_detail')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('quality_packing_certificates');
    }
}
