<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoicedateColumnInPackagingList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('export_paking_lists', function ($table) {
            $table->date('import_date')->default(date('Y-m-d'));
        });
        Schema::connection('mdf')->table('export_paking_lists', function ($table) {
            $table->date('import_date')->default(date('Y-m-d'));
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
            $table->dropColumn('import_date');
        });
        Schema::connection('mdf')->table('export_paking_lists', function ($table) {
            $table->dropColumn('import_date');
        });
    }
}
