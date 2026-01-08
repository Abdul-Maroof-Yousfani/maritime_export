<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderGatePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('sales_order_gate_passes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_no');
            $table->string('gate_pass_no');
            $table->date('date');
            $table->string('builty_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_number')->nullable();
            $table->string('transporter_name')->nullable();
            $table->string('arrival_note')->nullable();
            $table->decimal('recived_qty')->nullable();
            $table->string('description')->nullable();
            $table->string('user_name');
            $table->string('type')->comment(
                '1 => Get Pass In,
                2 => Get Pass Out'
            );
            $table->timestamps();
        });
        Schema::connection('mdf')->create('sales_order_gate_passes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('so_no');
            $table->string('gate_pass_no');
            $table->date('date');
            $table->string('builty_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_number')->nullable();
            $table->string('transporter_name')->nullable();
            $table->string('arrival_note')->nullable();
            $table->decimal('recived_qty')->nullable();
            $table->string('description')->nullable();
            $table->string('user_name');
            $table->string('type')->comment(
                '1 => Get Pass In,
                2 => Get Pass Out'
            );
            $table->timestamps();
        });
        // Schema::connection('mysql_test')->create('sales_order_gate_passes', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('so_no');
        //     $table->string('gate_pass_no');
        //     $table->date('date');
        //     $table->string('builty_no')->nullable();
        //     $table->string('vehicle_no')->nullable();
        //     $table->string('driver_name')->nullable();
        //     $table->string('driver_number')->nullable();
        //     $table->string('transporter_name')->nullable();
        //     $table->string('arrival_note')->nullable();
        //     $table->decimal('recived_qty')->nullable();
        //     $table->string('description')->nullable();
        //     $table->string('user_name');
        //     $table->string('type')->comment(
        //         '1 => Get Pass In,
        //         2 => Get Pass Out'
        //     );
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('sales_order_gate_passes');
        Schema::connection('mdf')->dropIfExists('sales_order_gate_passes');
        Schema::connection('mysql_test')->dropIfExists('sales_order_gate_passes');
    }
}
