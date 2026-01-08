<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMaterialRequestsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mdf')->table('material_requests', function (Blueprint $table) {
            $table->string('line_id')->nullable()->change();
            $table->string('machine_id')->nullable()->change();
        });

        Schema::connection('mysql2')->table('material_requests', function (Blueprint $table) {
            $table->string('line_id')->nullable()->change();
            $table->string('machine_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mdf')->table('material_requests', function (Blueprint $table) {
            $table->bigInteger('line_id')->change();
            $table->bigInteger('machine_id')->change();
        });

        Schema::connection('mysql2')->table('material_requests', function (Blueprint $table) {
            $table->bigInteger('line_id')->change();
            $table->bigInteger('machine_id')->change();
        });
    }
}

