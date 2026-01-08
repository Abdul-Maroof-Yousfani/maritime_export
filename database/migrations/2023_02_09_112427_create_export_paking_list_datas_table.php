<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportPakingListDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('export_paking_list_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('import_paking_list_id');
            $table->string('container')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->integer('qty')->nullable();
            $table->string('vechle')->nullable();
            $table->date('date_of_empty')->nullable();
            $table->date('date_of_loading')->nullable();
            $table->string('loading_port')->nullable();
            $table->string('status')->nullable();
            $table->string('username')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('export_paking_list_datas');
    }
}
