<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpectionChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('inpection_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('type')->default(1)->comment('1=first inspection,2=second inspection');
            $table->unsignedBigInteger('ins_id');
            $table->unsignedBigInteger('checker_id');
            $table->longText('comment');
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
        Schema::connection('mysql2')->dropIfExists('inpection_checklists');
    }
}
