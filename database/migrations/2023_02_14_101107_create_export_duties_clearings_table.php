<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportDutiesClearingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('export_duties_clearings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mf_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('shipment_date')->nullable();
            $table->date('delevery_date')->nullable();

            //E From
            $table->string('e_form_no')->nullable();
            $table->date('e_form_date')->nullable();
            $table->string('e_form_bank')->nullable();

            // Bill OF Lading
            $table->string('bill_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->string('hs_code')->nullable();
            $table->string('vessel_name')->nullable();

            //  Shipment Value 
            $table->integer('rate_per_ton')->nullable();
            $table->string('invoice_fcy')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->integer('invoice_value_pkr')->nullable();
            $table->string('shipment_term')->nullable();
            $table->string('short_realization')->nullable();
            $table->integer('income_tax')->nullable();
            $table->integer('eds_charges')->nullable();
            $table->string('pkr_realization')->nullable();
            $table->string('proceeds_realization_bank')->nullable();

            // Shipment clearing


            $table->string('crearing_agent')->nullable();
            $table->string('terminal')->nullable();
            $table->double('weboc_token_charges')->nullable();
            $table->double('psw_fee')->nullable();
            $table->string('Wharfage')->nullable();
            $table->double('terminal_handling_charges')->nullable();
            $table->double('fuel_adjustment_charges')->nullable();
            $table->double('documentation_charges')->nullable();
            $table->double('miscellaneous_charges')->nullable();
            $table->double('anf_expanse')->nullable();
            $table->double('storage_charges')->nullable();
            $table->double('agencey_charges')->nullable();
            

            // Transportation
            $table->string('transporter')->nullable();
            $table->string('container_cost')->nullable();
            $table->string('total_container_cost')->nullable();
            $table->string('craft_paear_cost')->nullable();
            
            

            // Buyer 
            $table->string('party_name')->nullable();
            $table->string('country')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('port_of_discharge')->nullable();

            $table->string('commodity')->nullable();
            $table->string('quality')->nullable();
            $table->string('quantity_ton')->nullable();
            $table->string('type')->nullable();
            $table->string('raw_material_cost_per_ton')->nullable();
            $table->string('container')->nullable();
            $table->string('cost_sales')->nullable();
            $table->string('labour_cost')->nullable();
            $table->string('shipment_labour_cost')->nullable();
            // Paking 
            $table->string('packing_type')->nullable();
            $table->string('packing_quality')->nullable();
            $table->string('no_of_begs')->nullable();
            $table->string('packing_cost_per_ton')->nullable();
            $table->string('packing_cost')->nullable();

            // Fumigation  & inspection 
            $table->string('fumigation_cost_per_ton')->nullable();
            $table->string('shipment_fumigation_cost')->nullable();
            $table->string('inspection_cost_per_ton')->nullable();
            $table->string('shipment_inspection_cost')->nullable();

            // FORWARDING
            $table->string('freight_forwarder')->nullable();
            $table->string('house_bill_no')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('export_freight_in_per_ton')->nullable();
            $table->string('export_freight_in_usd')->nullable();
            $table->string('export_freight_in_per_pkr')->nullable();
            $table->string('lifting_charges')->nullable();

            


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
        Schema::connection('mysql2')->dropIfExists('export_duties_clearings');
    }
}
