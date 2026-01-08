<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintingBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('printing_bags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('printing_bags');
            $table->decimal('bag_weight', 10, 3);
            $table->decimal('grams', 10, 3);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('printing_bags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('printing_bags');
            $table->decimal('bag_weight', 10, 3);
            $table->decimal('grams', 10, 3);
            $table->boolean('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('printing_bags');
        Schema::connection('mdf')->dropIfExists('printing_bags');
    }
}
