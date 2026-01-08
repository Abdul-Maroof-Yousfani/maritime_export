<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillCheckDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('bill_check_datas');
        Schema::connection('mdf')->dropIfExists('bill_check_datas');
        Schema::connection('mysql_test')->dropIfExists('bill_check_datas');

        Schema::connection('mysql2')->create('bill_check_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('billcheck_parent_id')->nullable();
            $table->string('final_ins_no', 255)->nullable();
            $table->string('final_ins_id')->nullable(); // Changed to string and nullable
            $table->string('date')->nullable();
            $table->string('truck_no', 255)->nullable();
            $table->string('received_bags')->nullable();
            $table->string('moisture')->nullable();
            $table->string('received_kg')->nullable();
            $table->string('rate_per_kg')->nullable();
            $table->string('cost_amount')->nullable();
            $table->string('freight')->nullable();
            $table->string('commission')->nullable();
            $table->string('bardana')->nullable();
            $table->string('broken')->nullable();
            $table->string('damage')->nullable();
            $table->string('chobba')->nullable();
            $table->string('chalky')->nullable();
            $table->string('o_v')->nullable();
            $table->string('look')->nullable();
            $table->string('discount')->default('0.00')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('bill_no', 255)->nullable();
    
            $table->timestamps();
        });

        Schema::connection('mdf')->create('bill_check_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('billcheck_parent_id')->nullable();
            $table->string('final_ins_no', 255)->nullable();
            $table->string('final_ins_id')->nullable(); // Changed to string and nullable
            $table->string('date')->nullable();
            $table->string('truck_no', 255)->nullable();
            $table->string('received_bags')->nullable();
            $table->string('moisture')->nullable();
            $table->string('received_kg')->nullable();
            $table->string('rate_per_kg')->nullable();
            $table->string('cost_amount')->nullable();
            $table->string('freight')->nullable();
            $table->string('commission')->nullable();
            $table->string('bardana')->nullable();
            $table->string('broken')->nullable();
            $table->string('damage')->nullable();
            $table->string('chobba')->nullable();
            $table->string('chalky')->nullable();
            $table->string('o_v')->nullable();
            $table->string('look')->nullable();
            $table->string('discount')->default('0.00')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('bill_no', 255)->nullable();
    
            $table->timestamps();
        });

        Schema::connection('mysql_test')->create('bill_check_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('billcheck_parent_id')->nullable();
            $table->string('final_ins_no', 255)->nullable();
            $table->string('final_ins_id')->nullable(); // Changed to string and nullable
            $table->string('date')->nullable();
            $table->string('truck_no', 255)->nullable();
            $table->string('received_bags')->nullable();
            $table->string('moisture')->nullable();
            $table->string('received_kg')->nullable();
            $table->string('rate_per_kg')->nullable();
            $table->string('cost_amount')->nullable();
            $table->string('freight')->nullable();
            $table->string('commission')->nullable();
            $table->string('bardana')->nullable();
            $table->string('broken')->nullable();
            $table->string('damage')->nullable();
            $table->string('chobba')->nullable();
            $table->string('chalky')->nullable();
            $table->string('o_v')->nullable();
            $table->string('look')->nullable();
            $table->string('discount')->default('0.00')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('bill_no', 255)->nullable();
    
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
        Schema::dropIfExists('bill_check_datas');
    }
}
