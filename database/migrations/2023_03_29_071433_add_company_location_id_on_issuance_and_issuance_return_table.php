<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyLocationIdOnIssuanceAndIssuanceReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('issuance', function (Blueprint $table) {
            $table->bigInteger('company_location_id')->default(1);
        });
        Schema::connection('mysql2')->table('issuance_returns', function (Blueprint $table) {
            $table->bigInteger('company_location_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('issuance', function (Blueprint $table) {
            $table->dropColumn('company_location_id');
        });
        Schema::connection('mysql2')->table('issuance_returns', function (Blueprint $table) {
            $table->dropColumn('company_location_id');
        });
    }
}
