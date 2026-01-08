<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('goods_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('maintenance_job_id');
            $table->bigInteger('department_id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->bigInteger('location_id');
            $table->string('sender_name');
            $table->date('return_date');
            $table->string('contact_person');
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('voucher_status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('goods_returns');
    }
}
