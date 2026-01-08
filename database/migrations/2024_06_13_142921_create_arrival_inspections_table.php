<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('arrival_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('po_id');
            $table->string('ins_no', 50);
            $table->date('date');
            $table->string('truck_no', 20);
            $table->text('product_description');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('no_of_bags');
            $table->unsignedBigInteger('pp_bags_id');
            $table->unsignedBigInteger('jute_bags');
            $table->text('shipment_origin');
            $table->string('bilty_no', 50);
            $table->date('bilty_date');
            $table->unsignedBigInteger('consignee_weight');
            $table->string('driver_name', 100);
            $table->string('transporter_name', 100);
            $table->boolean('satisfactory_status')->default(1)->comment('0 => no, 1 => yes');
            $table->boolean('corrective_action')->default(1)->comment('0 => Reject, 1 => Use as it is');
            $table->string('created_by', 100);
            $table->string('approved', 100);
            $table->tinyInteger('ins_status')->default(1)->comment('0 => pending, 1 => approved, 2 => Reject'); // Changed to tinyInteger
            $table->text('justification');
            $table->string('inspect_by', 100);

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
        Schema::connection('mysql2')->dropIfExists('arrival_inspections');
    }
}
