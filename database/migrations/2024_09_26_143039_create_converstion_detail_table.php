<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConverstionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('converstion_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_master_id');
            $table->date('conversion_date'); // CNV.Date
            $table->string('conversion_timing')->nullable(); // Timing
            $table->string('supervisor')->nullable(); // Supervisor
            $table->string('raw_material_id')->nullable(); // Name Raw Material Taken
            $table->string('store_location')->nullable(); // From Store Location
            $table->string('production_line')->nullable(); // Production Line #
            $table->string('packing')->nullable(); // Packing (Manual)
            $table->integer('received_qty')->nullable(); // Received Qty
            $table->string('uom')->nullable(); // UOM
            $table->decimal('conversion_tons', 8, 2)->nullable(); // Auto Conversion In Ton's
            $table->string('finish_good_id')->nullable(); // Produced Item Name
            $table->integer('finish_good_qty')->nullable(); // Final Produced Qty
            $table->string('finish_good_uom')->nullable(); // UOM for Final Produced Qty
            $table->string('storage_location')->nullable(); // Storage Location
            $table->string('purpose')->nullable(); // Purpose (Local/Export)
            $table->string('remarks')->nullable(); // Remarks
            $table->timestamps();
        });

        Schema::connection('mdf')->create('converstion_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_master_id');
            $table->date('conversion_date'); // CNV.Date
            $table->string('conversion_timing')->nullable(); // Timing
            $table->string('supervisor')->nullable(); // Supervisor
            $table->string('raw_material_id')->nullable(); // Name Raw Material Taken
            $table->string('store_location')->nullable(); // From Store Location
            $table->string('production_line')->nullable(); // Production Line #
            $table->string('packing')->nullable(); // Packing (Manual)
            $table->integer('received_qty')->nullable(); // Received Qty
            $table->string('uom')->nullable(); // UOM
            $table->decimal('conversion_tons', 8, 2)->nullable(); // Auto Conversion In Ton's
            $table->string('finish_good_id')->nullable(); // Produced Item Name
            $table->integer('finish_good_qty')->nullable(); // Final Produced Qty
            $table->string('finish_good_uom')->nullable(); // UOM for Final Produced Qty
            $table->string('storage_location')->nullable(); // Storage Location
            $table->string('purpose')->nullable(); // Purpose (Local/Export)
            $table->string('remarks')->nullable(); // Remarks
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('converstion_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('converstion_master_id');
            $table->date('conversion_date'); // CNV.Date
            $table->string('conversion_timing')->nullable(); // Timing
            $table->string('supervisor')->nullable(); // Supervisor
            $table->string('raw_material_id')->nullable(); // Name Raw Material Taken
            $table->string('store_location')->nullable(); // From Store Location
            $table->string('production_line')->nullable(); // Production Line #
            $table->string('packing')->nullable(); // Packing (Manual)
            $table->integer('received_qty')->nullable(); // Received Qty
            $table->string('uom')->nullable(); // UOM
            $table->decimal('conversion_tons', 8, 2)->nullable(); // Auto Conversion In Ton's
            $table->string('finish_good_id')->nullable(); // Produced Item Name
            $table->integer('finish_good_qty')->nullable(); // Final Produced Qty
            $table->string('finish_good_uom')->nullable(); // UOM for Final Produced Qty
            $table->string('storage_location')->nullable(); // Storage Location
            $table->string('purpose')->nullable(); // Purpose (Local/Export)
            $table->string('remarks')->nullable(); // Remarks
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
        Schema::dropIfExists('converstion_detail');
    }
}
