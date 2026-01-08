<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterSubItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('subitem', function ($table) {
            $table->string('pack_type')->after('pack_size')->nullable();
           
        });
        DB::connection('mysql2')->statement('ALTER TABLE subitem MODIFY pack_size VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('subitem', function(Blueprint $table)
        {
            //
            $table->dropColumn('pack_type');
        });
    }
}
