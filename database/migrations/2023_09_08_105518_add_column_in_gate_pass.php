<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInGatePass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_passes', function ($table) {
            $table->string('contact_no')->nullable();
        });
        Schema::connection('mdf')->table('gate_passes', function ($table) {
            $table->string('contact_no')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('gate_passes', function ($table) {
            $table->dropColumn('contact_no');
        });
        Schema::connection('mdf')->table('gate_passes', function ($table) {
            $table->dropColumn('contact_no');
        });
    }
}
