<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopMaterialIssuanceDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('workshop_material_issuance_id');
            $table->bigInteger('grn_data_id');
            $table->bigInteger('item_id');
            $table->bigInteger('department_id');
            $table->decimal('qty', 10, 2);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('workshop_material_issuance_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('workshop_material_issuance_id');
            $table->bigInteger('grn_data_id');
            $table->bigInteger('item_id');
            $table->bigInteger('department_id');
            $table->decimal('qty', 10, 2);
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
        Schema::connection('mysql2')->dropIfExists('workshop_material_issuance_datas');
        Schema::connection('mdf')->dropIfExists('workshop_material_issuance_datas');
    }
}
