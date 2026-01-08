<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnReciedve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->boolean('returnable_recieved')->default(0)->comment('0=>not recieved,1=>recieved');
            $table->string('recieving_date')->nullable();
            $table->string('recieving_user')->nullable();
        });
        Schema::connection('mdf')->table('gate_pass_returnable_datas', function (Blueprint $table) {
            $table->boolean('returnable_recieved')->default(0)->comment('0=>not recieved,1=>recieved');
            $table->string('recieving_date')->nullable();
            $table->string('recieving_user')->nullable();
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
