<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionGetPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('production_get_pass', function (Blueprint $table) {
            $table->increments('id');
            $table->string('po_no');
            $table->string('gate_pass_no');
            $table->string('inspection_no');
            $table->date('date');
            $table->string('builty_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('transporter_name')->nullable();
            $table->string('arrival_note')->nullable();
            $table->decimal('recived_qty')->nullable();
            $table->string('description')->nullable();
            $table->string('user_name');
            $table->string('get_pass_type')->comment(
                '1 => Get Pass In,
                2 => Get Pass Out'
            );
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
        Schema::connection('mysql2')->dropIfExists('production_get_pass');
    }
}
