<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsinPurchaseproductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
            $table->string('item_id')->nullable()->after('product_id');
            $table->string('is_param_edited')->nullable()->after('balance_qty');
            $table->string('editedjustification')->nullable()->after('is_param_edited');
            $table->longText('remarks')->nullable()->after('editedjustification');
        });
        Schema::connection('mdf')->table('production_purchase_orders', function (Blueprint $table) {
            $table->string('item_id')->nullable()->after('product_id');
            $table->string('is_param_edited')->nullable()->after('balance_qty');
            $table->string('editedjustification')->nullable()->after('is_param_edited');
            $table->longText('remarks')->nullable()->after('editedjustification');
        });
        Schema::connection('mysql_test')->table('production_purchase_orders', function (Blueprint $table) {
            $table->string('item_id')->nullable()->after('product_id');
            $table->string('is_param_edited')->nullable()->after('balance_qty');
            $table->string('editedjustification')->nullable()->after('is_param_edited');
            $table->longText('remarks')->nullable()->after('editedjustification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('production_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
        Schema::connection('mdf')->table('production_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
    }
}
