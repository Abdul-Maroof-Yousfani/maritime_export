<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingFieldsToSaleOrderDataExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('sale_order_data_exports', 'item_size')) {
                $table->string('item_size')->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_data_exports', 'quality')) {
                $table->string('quality')->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_data_exports', 'pack_uom')) {
                $table->string('pack_uom')->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_data_exports', 'total_qty')) {
                $table->decimal('total_qty', 10, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function (Blueprint $table) {
            $table->dropColumn(['item_size', 'quality', 'pack_uom', 'total_qty']);
        });
    }
}


