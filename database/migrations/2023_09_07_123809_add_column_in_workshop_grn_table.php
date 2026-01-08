<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInWorkshopGrnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('workshop_grns', function ($table) {
            $table->biginteger('location_id')->nullable();
        });
        Schema::connection('mdf')->table('workshop_grns', function ($table) {
            $table->biginteger('location_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('workshop_grns', function ($table) {
            $table->dropColumn('location_id');
        });
        Schema::connection('mdf')->table('workshop_grns', function ($table) {
            $table->dropColumn('location_id');
        });
    }
}
