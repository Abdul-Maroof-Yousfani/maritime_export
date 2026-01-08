<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('job_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jo_no');
            $table->string('product_code');
            $table->unsignedBigInteger('product_id');
            $table->decimal('qty')->nullable();
            $table->date('ship_date');
            $table->date('crop_year');
            $table->string('moisture')->nullable();
            $table->string('bag_front_image')->nullable();
            $table->string('bag_back_image')->nullable();
            $table->text('packing_a')->nullable();
            $table->text('packing_b')->nullable();
            $table->text('bag_stitching')->nullable();
             $table->decimal('max_broken_grains')->nullable();
             $table->decimal('damaged')->nullable();
             $table->decimal('chalky_grains')->nullable();
             $table->decimal('foreign_matters')->nullable();
             $table->decimal('foreign_grains')->nullable();
             $table->decimal('paddy_grains')->nullable();
             $table->decimal('red_stripped_kernal')->nullable();
             $table->string('whiteness')->nullable();
             $table->string('milling_degree')->nullable();
             $table->string('kernal_length')->nullable();
             $table->string('quality')->nullable();
             $table->string('empty_bags')->nullable();
             $table->string('destination')->nullable();
             $table->string('inspection_agency')->nullable();
             $table->string('bag_brand_name')->nullable();
             $table->boolean('status')->default(true);
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
        Schema::connection('mysql2')->dropIfExists('job_orders');
    }
}
