<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnsureIsAdvanceColumnExistsInSaleOrderExports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('sale_order_exports', function (Blueprint $table) {
            // Add is_advance column if it doesn't exist
            if (!Schema::connection('mysql2')->hasColumn('sale_order_exports', 'is_advance')) {
                $table->tinyInteger('is_advance')->default(0)->after('insurance_coverd');
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
            // Drop is_advance column if it exists
            if (Schema::connection('mysql2')->hasColumn('sale_order_exports', 'is_advance')) {
                $table->dropColumn('is_advance');
            }
        });
    }
}

