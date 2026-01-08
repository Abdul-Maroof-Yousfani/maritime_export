<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstInsNoColomnArrivalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('first_ins_no')->nullable()->after('ins_no');
        });
        Schema::connection('mdf')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('first_ins_no')->nullable()->after('ins_no');
        });
        Schema::connection('mysql_test')->table('arrival_inspections', function (Blueprint $table) {
            $table->string('first_ins_no')->nullable()->after('ins_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arrival_inspections', function (Blueprint $table) {
            Schema::connection('mysql2')->table('arrival_inspections', function (Blueprint $table) {
                $table->string('first_ins_no')->nullable()->after('ins_no');
            });
            Schema::connection('mdf')->table('arrival_inspections', function (Blueprint $table) {
                $table->string('first_ins_no')->nullable()->after('ins_no');
            });
            Schema::connection('mysql_test')->table('arrival_inspections', function (Blueprint $table) {
                $table->string('first_ins_no')->nullable()->after('ins_no');
            });
        });
    }
}
