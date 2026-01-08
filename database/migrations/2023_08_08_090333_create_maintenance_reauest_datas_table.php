<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceReauestDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('maintenance_reauest_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('maintenance_request_id');
            $table->bigInteger('item_id');
            $table->decimal('qty',10,3);
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
        Schema::connection('mysql2')->dropIfExists('maintenance_reauest_datas');
    }
}
