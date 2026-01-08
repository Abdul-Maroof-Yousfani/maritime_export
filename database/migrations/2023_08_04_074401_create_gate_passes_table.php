<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('gate_passes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gate_pass_no');
            $table->date('gate_pass_date');
            $table->string('mo_no')->nullable();
            $table->string('good_taken_by')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->tinyInteger('gate_pass_type');
            $table->string('created_by')->nullable();
            $table->integer('voucher_status')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('gate_passes');
    }
}
