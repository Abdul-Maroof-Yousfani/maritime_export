<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInPrintingBagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('printing_bags', function ($table) {
            $table->string('pack_type')->nullable()->after('id');
        });
        Schema::connection('mdf')->table('printing_bags', function ($table) {
            $table->string('pack_type')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('printing_bags', function ($table) {
            $table->dropColumn('pack_type');
        });
        Schema::connection('mdf')->table('printing_bags', function ($table) {
            $table->dropColumn('pack_type');
        });
    }
}
