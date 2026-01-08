<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCropBasedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql2')->hasColumn('crop_baseds', 'name')) {
            Schema::connection('mysql2')->table('crop_baseds', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
        Schema::connection('mysql2')->table('crop_baseds', function (Blueprint $table) {
            $table->date('date_from');
            $table->date('date_to');
        });
        Schema::connection('mysql2')->table('commodity_purchase_orders', function (Blueprint $table) {
            $table->bigInteger('transporter_id');
            $table->bigInteger('agent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('crop_baseds', function (Blueprint $table) {
            $table->dropColumn('date_from');
            $table->dropColumn('date_to');
        });
        Schema::connection('mysql2')->table('commodity_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('transporter_id');
            $table->dropColumn('agent_id');
        });
    }
}
