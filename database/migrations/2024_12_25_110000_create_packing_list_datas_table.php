<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackingListDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('packing_list_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('packing_list_id')->nullable();
            $table->integer('commercial_invoice_data_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->text('description')->nullable(); // FROZEN SQUID WHOLE PACKING: 20 KG/CTN (LOLIGO EDULIS)
            $table->string('grade_size')->nullable(); // 20/40-A+
            $table->integer('total_cartons')->default(0); // 1250
            $table->decimal('total_net_kgs', 15, 2)->default(0); // 25000
            $table->decimal('total_gross_kgs', 15, 2)->default(0); // 28750
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
        Schema::connection('mysql2')->dropIfExists('packing_list_datas');
    }
}
