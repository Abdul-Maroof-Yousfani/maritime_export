<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGmApprovalColumnInDemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('demand', function (Blueprint $table) {
            $table->integer('gm_approval_status')->nullable();
            $table->string('gm_approval_username')->nullable();
            $table->longText('gm_description')->nullable();
        });
        Schema::connection('mdf')->table('demand', function (Blueprint $table) {
            $table->integer('gm_approval_status')->nullable();
            $table->string('gm_approval_username')->nullable();
            $table->longText('gm_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('demand', function (Blueprint $table) {
            $table->dropColumn('gm_approval_status');
            $table->dropColumn('gm_approval_username')->nullable();
            $table->dropColumn('gm_description');
        });
        Schema::connection('mdf')->table('demand', function (Blueprint $table) {
            $table->dropColumn('gm_approval_status');
            $table->dropColumn('gm_description');
            $table->dropColumn('gm_approval_username')->nullable();
        });
    }
}
