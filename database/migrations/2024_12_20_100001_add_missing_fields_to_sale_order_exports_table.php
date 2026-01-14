<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingFieldsToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'currencey_id')) {
                $table->integer('currencey_id')->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'currencey_rate')) {
                $table->decimal('currencey_rate', 10, 2)->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'exchange_rate')) {
                $table->decimal('exchange_rate', 10, 2)->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'contract_no')) {
                $table->string('contract_no')->nullable();
            }
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'voucher_heading')) {
                $table->string('voucher_heading')->nullable();
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
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            $table->dropColumn(['currencey_id', 'currencey_rate', 'exchange_rate', 'contract_no', 'voucher_heading']);
        });
    }
}


