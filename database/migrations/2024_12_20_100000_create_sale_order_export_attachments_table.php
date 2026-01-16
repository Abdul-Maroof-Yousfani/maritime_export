<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderExportAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('sale_order_export_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_order_export_id');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
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
        Schema::connection('mysql2')->dropIfExists('sale_order_export_attachments');
    }
}



