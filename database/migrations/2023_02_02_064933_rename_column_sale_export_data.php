<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnSaleExportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function($table) {
            $table->renameColumn('pack_size_pack_type', 'pack_type');
            $table->renameColumn('pack_qty', 'total_qty');
            $table->integer('status')->default(1);
            $table->string('username')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_data_exports', function($table) {
            $table->renameColumn('pack_type', 'pack_size_pack_type');
            $table->renameColumn('total_qty', 'pack_qty');
        });
    }
}
