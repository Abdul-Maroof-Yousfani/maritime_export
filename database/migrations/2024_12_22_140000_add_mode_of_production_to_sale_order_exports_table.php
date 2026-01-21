<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeOfProductionToSaleOrderExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add mode_of_production column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'mode_of_production')) {
                $table->string('mode_of_production')->nullable()->after('is_advance');
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
            // Drop mode_of_production column if it exists
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'mode_of_production')) {
                $table->dropColumn('mode_of_production');
            }
        });
    }
}

