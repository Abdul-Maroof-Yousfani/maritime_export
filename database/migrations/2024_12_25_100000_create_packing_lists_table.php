<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('packing_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commercial_invoice_id')->nullable();
            $table->string('packing_list_no')->nullable(); // Auto-generated packing list number
            $table->string('invoice_no')->nullable(); // From commercial invoice (for reference)
            $table->date('date')->nullable();
            $table->string('gd_no')->nullable(); // KPEX-SB-86349-23-11-2025
            $table->string('container_no')->nullable(); // SEGU9709378
            $table->text('consignee_name')->nullable();
            $table->text('consignee_address')->nullable();
            $table->string('vessel_voyage')->nullable(); // CSPC LEO 004E
            $table->string('port_from')->nullable(); // KARACHI, PAKISTAN
            $table->string('port_to')->nullable(); // HO CHI MINH PORT, VIETNAM
            $table->string('payment_term')->nullable(); // BY TT
            $table->decimal('gross_weight', 15, 2)->nullable(); // Mandatory field, default null
            $table->integer('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('packing_lists');
    }
}
