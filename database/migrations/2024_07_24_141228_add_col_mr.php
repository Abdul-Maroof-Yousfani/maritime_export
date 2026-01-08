<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColMr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->table('material_requests', function (Blueprint $table) {
            $table->bigInteger('line_id')->after('mr_no');
            $table->bigInteger('machine_id')->after('line_id');
        });
        Schema::connection('mysql2')->table('material_requests', function (Blueprint $table) {
            $table->bigInteger('line_id')->after('mr_no');
            $table->bigInteger('machine_id')->after('line_id');
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
