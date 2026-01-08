<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInOriginCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('quality_declear_certificates', function (Blueprint $table) {
            $table->date('certificate_date');
            $table->longText('description_of_goods')->nullable();
            $table->longText('other_detail')->nullable();
            $table->longText('other_detail_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('quality_declear_certificates', function (Blueprint $table) {
            $table->dropColumn('certificate_date')->nullable();
            $table->dropColumn('description_of_goods')->nullable();
            $table->dropColumn('other_detail')->nullable();
            $table->dropColumn('other_detail_2')->nullable();
        });
    }
}
