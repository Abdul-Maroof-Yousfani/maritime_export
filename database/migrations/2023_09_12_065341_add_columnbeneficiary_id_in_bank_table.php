<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnbeneficiaryIdInBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('banks', function ($table) {
            $table->biginteger('beneficiary_id')->nullable();
        });
        Schema::connection('mdf')->table('banks', function ($table) {
            $table->biginteger('beneficiary_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('banks', function ($table) {
            $table->dropColumn('beneficiary_id');
        });
        Schema::connection('mdf')->table('banks', function ($table) {
            $table->dropColumn('beneficiary_id');
        });
    }
}
