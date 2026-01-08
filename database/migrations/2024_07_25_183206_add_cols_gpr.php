<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsGpr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->boolean('returnable_recieved')->default(1);
            $table->string('recieving_date')->nullable();
            $table->string('recieving_user')->nullable();
        });
        Schema::connection('mdf')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->boolean('returnable_recieved')->default(1);
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
        Schema::connection('mysql2')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->dropColumn('returnable_recieved');
            $table->dropColumn('recieving_date');
            $table->dropColumn('recieving_user');
        });
        Schema::connection('mdf')->table('gate_pass_returnables', function (Blueprint $table) {
            $table->dropColumn('returnable_recieved');
            $table->dropColumn('recieving_date');
            $table->dropColumn('recieving_user');
        });
    }
}
