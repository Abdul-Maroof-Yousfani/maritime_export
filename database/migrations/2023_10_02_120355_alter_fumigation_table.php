<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFumigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('fumigation_certificates', function($table) {
            $table->string('details1')->after('fumigation_text_area')->nullable();
            $table->string('details2')->after('fumigation_text_area')->nullable();
            $table->integer('no_of_bags')->after('fumigation_text_area')->nullable();
            $table->string('date')->after('fumigation_text_area')->nullable();
            $table->string('fumigation_created_by')->after('fumigation_text_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('fumigation_certificates', function (Blueprint $table) {
            $table->dropColumn(['details1','details2','no_of_bags','date','fumigation_created_by']);
        });
    }
}
