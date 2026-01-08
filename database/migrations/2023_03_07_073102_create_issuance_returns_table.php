<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuanceReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql2")->create('issuance_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->string('issuance_id');
            $table->string('issuance_voucher_no');
            $table->date('issuance_voucher_date');
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('machine_id')->nullable();
            $table->bigInteger('line_id')->nullable();
            $table->string('receipt_serial_no')->nullable();
            $table->longText('description')->nullable();
            $table->integer('voucher_status')->nullable()->default(1)->comment("1=>PENDING, 2=>Approve");
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
        Schema::dropIfExists('issuance_returns');
    }
}
