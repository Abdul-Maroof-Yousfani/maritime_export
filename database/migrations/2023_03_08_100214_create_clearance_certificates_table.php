<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClearanceCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('clearance_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ex_duities_id')->nullable();
              // clearance Certificate

              $table->string('invoice_no')->nullable();
              $table->date('invoice_date')->nullable();
              $table->string('clearance_certificate_no')->nullable();
              $table->string('consignee')->nullable();
              $table->string('vessel_name')->nullable();
              $table->string('port_of_loading')->nullable();
              $table->string('container_no')->nullable();
              $table->string('port_of_discharge')->nullable();
              $table->string('description_og_good')->nullable();
              $table->string('total_weight')->nullable();
              $table->string('health')->nullable();
              $table->string('lead')->nullable();
              $table->string('arsenic')->nullable();
              $table->string('cadmium')->nullable();
              $table->string('mercury')->nullable();
              $table->string('mercury_organic_pesticides')->nullable();
              $table->string('hexachlorocy')->nullable();
              $table->string('ddt_4_4')->nullable();
              $table->string('d_2_4')->nullable();
              $table->string('ddt_2_4')->nullable();
              $table->string('dde_4_4')->nullable();
              $table->string('dde_2_4')->nullable();
              $table->string('ddd_4_4')->nullable();
              $table->string('aflatoxin_B1')->nullable();
              $table->string('aflatoxin_B2')->nullable();
              $table->string('aflatoxin_G1')->nullable();
              $table->string('aflatoxin_G2')->nullable();
              $table->string('orchratoxin_a')->nullable();
              $table->string('t_2_toxins')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('clearance_certificates');
    }
}
