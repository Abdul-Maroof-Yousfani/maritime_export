<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnInGrnDataWorkshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('workshop_grns', function (Blueprint $table) {
            $table->bigInteger('gate_pass_id')->nullable();
            $table->integer('is_complete')->default(0)->comment("0=>NO, 1=>YES");
        });
        Schema::connection('mdf')->table('workshop_grns', function (Blueprint $table) {
            $table->bigInteger('gate_pass_id')->nullable();
            $table->integer('is_complete')->default(0)->comment("0=>No, 1=>YES");
        });

        Schema::connection('mysql2')->table('workshop_grn_datas', function (Blueprint $table) {
            $table->integer('status')->default(1);
            $table->decimal('repair_cost', 10, 3)->nullable();
        });
        Schema::connection('mdf')->table('workshop_grn_datas', function (Blueprint $table) {
            $table->integer('status')->default(1);
            $table->decimal('repair_cost', 10, 3)->nullable();
        });

        Schema::connection('mysql2')->table('workshop_material_issuances', function (Blueprint $table) {
            $table->integer('voucher_status')->default(1);
            $table->bigInteger('maintenance_job_id')->nullable();
        });
        Schema::connection('mdf')->table('workshop_material_issuances', function (Blueprint $table) {
            $table->integer('voucher_status')->default(1);
            $table->bigInteger('maintenance_job_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('workshop_grns', function (Blueprint $table) {
            $table->dropColumn('gate_pass_id');
            $table->dropColumn('is_complete');
        });
        Schema::connection('mdf')->table('workshop_grns', function (Blueprint $table) {
            $table->dropColumn('gate_pass_id');
            $table->dropColumn('is_complete');
        });


        Schema::connection('mysql2')->table('workshop_grn_datas', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('repair_cost');
        });
        Schema::connection('mdf')->table('workshop_grn_datas', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('repair_cost');
        });


        Schema::connection('mysql2')->table('workshop_material_issuances', function (Blueprint $table) {
            $table->dropColumn('voucher_status');
            $table->dropColumn('maintenance_job_id');
        });
        Schema::connection('mdf')->table('workshop_material_issuances', function (Blueprint $table) {
            $table->dropColumn('voucher_status');
            $table->dropColumn('maintenance_job_id');
        });
    }
}
