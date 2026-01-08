<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInQtyCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('qty_calculations', function (Blueprint $table) {
            $table->decimal('traller_from')->default(0);
            $table->decimal('traller_to')->default(0);
            $table->decimal('truck_from')->default(0);
            $table->decimal('truck_to')->default(0);
            $table->decimal('bag_from')->default(0);
            $table->decimal('bag_to')->default(0);
            $table->decimal('kg_from')->default(0);
            $table->decimal('kg_to')->default(0);
            $table->decimal('katta_from')->default(0);
            $table->decimal('katta_to')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('qty_calculations', function (Blueprint $table) {
            $table->dropColumn('traller_from')->default(0);
            $table->dropColumn('traller_to')->default(0);
            $table->dropColumn('truck_from')->default(0);
            $table->dropColumn('truck_to')->default(0);
            $table->dropColumn('bag_from')->default(0);
            $table->dropColumn('bag_to')->default(0);
            $table->dropColumn('kg_from')->default(0);
            $table->dropColumn('kg_to')->default(0);
            $table->dropColumn('katta_from')->default(0);
            $table->dropColumn('katta_to')->default(0);
        });
    }
}
