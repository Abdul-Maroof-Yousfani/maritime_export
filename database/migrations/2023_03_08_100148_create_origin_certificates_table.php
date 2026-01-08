<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('origin_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ex_duities_id')->nullable();
             // Origin Certificate
             $table->string('exporter_name')->nullable();
             $table->string('exporter_address')->nullable();
             $table->string('consignee_name')->nullable();
             $table->string('consignee_address')->nullable();
             $table->string('exporter_membership_no')->nullable();
             $table->string('mode_transport')->nullable();
             $table->string('bl_no_date')->nullable();
             $table->string('shiper_name')->nullable();
             $table->string('marks_number')->nullable();
             $table->string('description_of_good_origin')->nullable();
             $table->string('country_origin')->nullable();
             $table->string('neight_weight')->nullable();
             $table->string('gross_weight')->nullable();
             $table->string('name_origin')->nullable();
             $table->string('designation_origin')->nullable();
             $table->string('company')->nullable();
             $table->string('place')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('origin_certificates');
    }
}
