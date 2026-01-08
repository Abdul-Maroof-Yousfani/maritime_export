<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnInClearenceCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('clearance_certificates', function (Blueprint $table) {
            $table->longText('specification')->nullable();
            $table->longText('description_og_good')->change();
            $table->longText('consignee')->change();
            $table->longText('container_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('clearance_certificates', function (Blueprint $table) {
            $table->dropColumn('specification');
            $table->string('description_og_good')->change();
            $table->string('consignee')->change();
            $table->string('container_no')->change();
        });
    }
}
