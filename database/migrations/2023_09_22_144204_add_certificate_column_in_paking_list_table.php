<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificateColumnInPakingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_paking_lists', function ($table) {
            $table->integer('fumigation_status')->after('status')->default(0);
            $table->integer('origin_status')->after('status')->default(0);
            $table->integer('clearance_status')->after('status')->default(0);
            $table->integer('quality_declear_status')->after('status')->default(0);
            $table->integer('quality_packing_status')->after('status')->default(0);
        });
        Schema::connection('mdf')->table('export_paking_lists', function ($table) {
            $table->integer('fumigation_status')->after('status')->default(0);
            $table->integer('origin_status')->after('status')->default(0);
            $table->integer('clearance_status')->after('status')->default(0);
            $table->integer('quality_declear_status')->after('status')->default(0);
            $table->integer('quality_packing_status')->after('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('export_paking_lists', function ($table) {
            $table->dropColumn('fumigation_status');
            $table->dropColumn('origin_status');
            $table->dropColumn('clearance_status');
            $table->dropColumn('quality_declear_status');
            $table->dropColumn('quality_packing_status');
        });
        Schema::connection('mdf')->table('export_paking_lists', function ($table) {
            $table->dropColumn('fumigation_status');
            $table->dropColumn('origin_status');
            $table->dropColumn('clearance_status');
            $table->dropColumn('quality_declear_status');
            $table->dropColumn('quality_packing_status');
        });
    }
}
