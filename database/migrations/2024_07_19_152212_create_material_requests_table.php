<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('material_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mr_no');
            $table->date('mr_date')->nullable();
            $table->string('department_id')->nullable();
            $table->string('requested_by')->nullable();
            $table->longText('remarks')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::connection('mdf')->create('material_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mr_no');
            $table->date('mr_date')->nullable();
            $table->string('department_id')->nullable();
            $table->string('requested_by')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('material_requests');
        Schema::connection('mdf')->dropIfExists('material_requests');
    }
}
