<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificateNoColQualityPackingCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('quality_packing_certificates', function (Blueprint $table) {
            $table->string('quality_certificate_no')->nullable();
            $table->date('quality_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('quality_packing_certificates', function (Blueprint $table) {
            $table->dropColumn('quality_certificate_no');
            $table->dropColumn('quality_date');
        });
    }
}
