<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInExportOrderAndOrderData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function ($table) {
            $table->string('product_specification')->nullable();
            $table->string('correspondent_account_no')->nullable();
            $table->longtext('correspondent_account_address')->nullable();
            $table->biginteger('correspondent_bank_id')->nullable();
            $table->biginteger('payment_days')->nullable();
        });
        Schema::connection('mdf')->table('sale_order_exports', function ($table) {
            $table->string('product_specification')->nullable();
            $table->string('correspondent_account_no')->nullable();
            $table->longtext('correspondent_account_address')->nullable();
            $table->biginteger('correspondent_bank_id')->nullable();
            $table->biginteger('payment_days')->nullable();
        });
        Schema::connection('mysql2')->table('sale_order_data_exports', function ($table) {
            $table->decimal('no_of_container')->default(0);
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function ($table) {
            $table->decimal('no_of_container')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function ($table) {
            $table->dropColumn('product_specification');
            $table->dropColumn('correspondent_account_no');
            $table->dropColumn('correspondent_account_address');
            $table->dropColumn('correspondent_bank_id');
            $table->dropColumn('payment_days');
        });
        Schema::connection('mdf')->table('sale_order_exports', function ($table) {
            $table->dropColumn('product_specification');
            $table->dropColumn('correspondent_account_no');
            $table->dropColumn('correspondent_account_address');
            $table->dropColumn('correspondent_bank_id');
            $table->dropColumn('payment_days');
        });
        Schema::connection('mysql2')->table('sale_order_data_exports', function ($table) {
            $table->dropColumn('no_of_container');
        });
        Schema::connection('mdf')->table('sale_order_data_exports', function ($table) {
            $table->dropColumn('no_of_container');
        });
    }
}
