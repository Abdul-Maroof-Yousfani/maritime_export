<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('slabs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('slab_type_id');
            $table->decimal('from',10,2);
            $table->decimal('to',10,2);
            $table->decimal('amount',10,2);
            $table->longText('remark')->nullable();
            $table->boolean('status');
            $table->date('date');
            $table->string('username');
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
        Schema::connection('mysql2')->dropIfExists('slabs');
    }
}
