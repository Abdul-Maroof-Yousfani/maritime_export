<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('attachements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_src')->nullable();
            $table->string('status')->defalt(1);
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();         
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
        Schema::connection('mysql2')->dropIfExists('attachements');
    }
}
