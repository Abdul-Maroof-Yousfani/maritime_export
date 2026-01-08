<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql2')->hasColumn('product', 'packing_type')) {
            Schema::connection('mysql2')->table('product', function (Blueprint $table) {
                $table->dropColumn('packing_type');
            });
        }
        Schema::connection('mysql2')->table('product', function (Blueprint $table) {
            $table->string('packing_type',225)->nullable();
            $table->string('brand')->nullable();
            $table->bigInteger('product_type')->nullable();
            $table->renameColumn('batch_code', 'crop_based');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('product', function(Blueprint $table) {
            $table->dropColumn('packing_type');
            $table->dropColumn('brand');
            $table->dropColumn('product_type');
            $table->renameColumn('crop_based', 'batch_code');
        });
    }
}
