<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColIngatePassReturnable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection('mysql2')->table('material_requests', function (Blueprint $table) {
            $table->string('issuance_status')->default('1')->comment('1 => issuance not created, 2 => issuance created');
        });
        
        Schema::connection('mdf')->table('material_requests', function (Blueprint $table) {
            $table->string('issuance_status')->default('1')->comment('1 => issuance not created, 2 => issuance created');
        });
        

        Schema::connection('mdf')->table('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->bigInteger('department_id');
        });
        Schema::connection('mysql2')->table('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->bigInteger('department_id');
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
