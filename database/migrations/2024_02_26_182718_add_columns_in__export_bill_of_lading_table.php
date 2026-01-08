<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInExportBillOfLadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    // public function up()
    // {
    //     Schema::connection('mysql2')->table('export_bill_of_ladings', function(Blueprint $table){
    //         $table->string('booking_no')->nullable();
    //         $table->string('forwarder')->nullable();
    //     });
    //     Schema::connection('mdf')->table('export_bill_of_ladings', function(Blueprint $table){
    //         $table->string('booking_no')->nullable();
    //         $table->string('forwarder')->nullable();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::connection('mysql2')->table('export_bill_of_ladings', function(Blueprint $table){
    //         $table->dropColumn('booking_no');
    //         $table->dropColumn('forwarder');
    //     });
    //     Schema::connection('mdf')->table('export_bill_of_ladings', function(Blueprint $table){
    //         $table->dropColumn('booking_no');
    //         $table->dropColumn('forwarder');
    //     });
    // }
}
