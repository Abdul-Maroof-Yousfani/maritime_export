<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColInInspectionstype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('type')->default(1);
        });
        Schema::connection('mdf')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('type')->default(1);
        });
        Schema::connection('mysql_test')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
