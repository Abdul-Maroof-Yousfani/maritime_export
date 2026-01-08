<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopMaterialIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('workshop_material_issuances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->longText('description');
            $table->boolean('status')->default(1);
            $table->string('username');
            $table->timestamps();
        });
        Schema::connection('mdf')->create('workshop_material_issuances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->longText('description');
            $table->boolean('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('workshop_material_issuances');
        Schema::connection('mdf')->dropIfExists('workshop_material_issuances');
    }
}
